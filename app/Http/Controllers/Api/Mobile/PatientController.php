<?php

namespace App\Http\Controllers\Api\Mobile;

use Carbon\Carbon;
use App\Models\Slot;
use App\Models\Booking;
use App\Traits\Uploader;
use App\Models\SlotRange;
use Illuminate\Http\Request;
use App\Models\DoctorProfile;
use App\Models\GroupTherapist;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\ApiController;
use App\Http\Resources\BookedSlotResource;
use App\Http\Requests\UpdatePatientRequest;
use App\Http\Resources\JoinedGroupsResource;
use App\Http\Resources\PatientProfileResource;

class PatientController extends ApiController
{
    use Uploader;

    public function getProfile()
    {
        $patient = auth()->user();
        $this->patientOnly($patient);

        return PatientProfileResource::make($patient);
    }

    public function updateProfile(UpdatePatientRequest $request)
    {
        $patient = auth()->user();
        $this->patientOnly($patient);

        $patient->update($request->validated());

        return PatientProfileResource::make($patient);
    }

    public function updatePassword(Request $request)
    {
        $patient = auth()->user();
        $this->patientOnly($patient);

        $this->validate($request, [
            "password" => "required|min:4|max:250"
        ]);

        $hashedPassword = Hash::make($request->password);
        $patient->update(["password" => $hashedPassword]);

        return PatientProfileResource::make($patient)->additional(['msg' => 'Password is updated successfully']);
    }

    public function updateAvatar(Request $request)
    {
        $patient = auth()->user();
        $this->patientOnly($patient);

        $this->validate($request, [
            'avatar' => 'required|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->avatar) {
            $this->deleteIfExist($patient, 'avatar');
            $this->uploads($patient, $request->avatar, 'avatars', 'avatar');
            $patient->refresh();
        }

        return PatientProfileResource::make($patient)->additional(['msg' => 'Avatar is updated successfully']);
    }

    /*
    * Groups
    */
    public function joinGroup(Request $request)
    {
        $patient = auth()->user();
        $this->patientOnly($patient);

        $this->validate($request, [
            'group_id' => 'required|exists:group_therapists,id',
        ]);

        $group = GroupTherapist::findOrFail($request->group_id);
        $seatsAvailable = $group->seats - $group->joiners()->count();

        if ($seatsAvailable <= 0) {
            return response()->json(['msg' => 'This group is already full.']);
        }

        if ($patient->joinGroupTherapists()->where('group_therapist_id', $group->id)->exists()) {
            return response()->json(['msg' => 'You have already joined this group.']);
        }

        $patientTimeZone = $patient->timeZone?->name;
        $date =  Carbon::parse($group->date);
        $startTime =  Carbon::createFromFormat('H:i:s', $group->start_time, 'UTC')->setTimezone($patientTimeZone);


        if (($date->isPast() && !$date->isToday()) || ($date->isToday() && $startTime->isPast())) {
            return response()->json(['msg' => 'This group has already passed and cannot be joined.']);
        }


        $patient->joinGroupTherapists()->attach($request->group_id, [
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['msg' => 'The patient has successfully joined the group.']);
    }

    public function joinedGroups(Request $request)
    {
        $patient = auth()->user();
        $this->patientOnly($patient);

        $joinedGroups = $patient->joinGroupTherapists()->get();

        $upcomingGroups = [];
        $passedGroups = [];

        $patientTimeZone = $patient->timeZone?->name;

        foreach ($joinedGroups as $joinedGroup) {
            $group = GroupTherapist::find($joinedGroup->pivot->group_therapist_id);
            $date = Carbon::parse($group->date);
            $startTime =  Carbon::createFromFormat('H:i:s', $group->start_time, 'UTC')->setTimezone($patientTimeZone);
            if ($date->isFuture() || ($date->isToday() && $startTime->isFuture())) {
                $upcomingGroups[] = new JoinedGroupsResource($group);
            } else {
                $passedGroups[] = new JoinedGroupsResource($group);
            }
        }

        return response()->json([
            'upcoming_groups' => $upcomingGroups,
            'passed_groups' => $passedGroups,
        ]);
    }


    /*
    * Slots
    */
    public function bookSlot(Request $request)
    {
        $patient = auth()->user();
        $this->patientOnly($patient);

        $this->validate($request, [
            'slot_id' => 'required|exists:slot_ranges,id',
            'date' => 'required|date_format:Y-m-d|after_or_equal:today',
        ]);

        $doctorId = Slot::whereHas('slotRanges', function ($query) use ($request) {
            $query->where('id', $request->slot_id);
        })->value('user_id');

        $slotTimes =  SlotRange::where('id', $request->slot_id)->first(['time_from', 'time_to']);

        // Check if the slot is already booked by the patient
        $isAlreadyBooked = Booking::where('doctor_id', $doctorId)
            ->where('date', $request->date)
            ->where('time_from', $slotTimes->time_from)
            ->where('time_to', $slotTimes->time_to)
            ->exists();

        if ($isAlreadyBooked) {
            return response()->json([
                'msg' => 'This slot is already booked.', 'status' => false
            ]);
        }

        // Check if the requested date matches any day in the slot_ranges table
        $isDateMatched = SlotRange::where('id', $request->slot_id)
            ->where('day', '=', date('l', strtotime($request->date)))
            ->exists();

        if (!$isDateMatched) {
            return response()->json([
                'msg' => 'The requested date does not match any available days.', 'status' => false
            ]);
        }
        $doctorPrice = DoctorProfile::where('user_id', $doctorId)->value('price');

        Booking::create([
            'doctor_id' => $doctorId,
            'patient_id' => $patient->id,
            'date' => $request->date,
            'time_from' => $slotTimes->time_from,
            'time_to' => $slotTimes->time_to,
            'price' => $doctorPrice,
        ]);

        return response()->json([
            'msg' => 'The patient has successfully booked the slot.', 'status' => true
        ]);
    }

    public function bookedSlots(Request $request)
    {
        $patient = auth()->user();
        $this->patientOnly($patient);

        $bookedSlots = $patient->bookedSlots()->get();


        return BookedSlotResource::collection($bookedSlots);
    }

    private function patientOnly($user)
    {
        if ($user->user_type != "patient") {
            abort($this->errorResponse('Please login with patient account', 401));
        }
    }
}
