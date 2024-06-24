<?php

namespace App\Http\Controllers\Api\Mobile;

use Carbon\Carbon;
use App\Models\Slot;
use App\Models\SlotRange;
use Illuminate\Support\Str;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Models\GroupTherapist;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\ApiController;
use App\Http\Resources\SlotRangeResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UpdateDoctorRequest;
use App\Http\Resources\DoctorHomeResource;
use App\Http\Resources\DoctorGroupsResource;
use App\Http\Resources\DoctorProfileResource;

class DoctorController extends ApiController
{
    use ApiResponser;

    public function home()
    {
        $doctor = auth()->user();
        $this->doctorOnly($doctor);
        return $this->successResponse(data: DoctorHomeResource::make($doctor));

    }

    /*
     * Profile
     */
    public function getProfile()
    {
        $doctor = auth()->user();
        $this->doctorOnly($doctor);

        return DoctorProfileResource::make($doctor);
    }

    public function updateProfile(UpdateDoctorRequest $request)
    {
        $doctor = auth()->user();
        $this->doctorOnly($doctor);

        $doctor->update($request->validated());

        return DoctorProfileResource::make($doctor);
    }

    public function updatePassword(Request $request)
    {
        $doctor = auth()->user();
        $this->doctorOnly($doctor);

        $this->validate($request, [
            "password" => "required|min:4|max:250"
        ]);

        $hashedPassword = Hash::make($request->password);
        $doctor->update(["password" => $hashedPassword]);

        return DoctorProfileResource::make($doctor)->additional(['msg' => 'Password is updated successfully']);
    }

    /*
     * Groups
     */
    public function groups()
    {
        $doctor = auth()->user();
        $this->doctorOnly($doctor);

        $doctorGroups = $doctor->where('id', $doctor->id)
            ->whereHas('doctorProfile')
            ->with(['doctorProfile', 'groupTherapists'])
            ->first();
        return DoctorGroupsResource::make($doctorGroups);
    }

    public function createGroup(Request $request)
    {
        $doctor = auth()->user();
        $this->doctorOnly($doctor);


        $this->validate($request, [
            "title" => "required|string|max:300",
            "desc" => "nullable|string|max:10000",
            "date" => "required|date_format:Y-m-d",
            "seats" => "required|integer",
            "start_time" => "required|date_format:H:i",
            "finish_time" => "required|date_format:H:i|after:start_time",
        ]);

        $data = $request->only('title', 'desc', 'date', 'seats', 'start_time', 'finish_time');
        $data['user_id'] = $doctor->id;
        GroupTherapist::create($data);

        return $this->successResponse(message: "Your group created successfully");
    }
    public function updateGroup(Request $request)
    {
        $doctor = auth()->user();
        $this->doctorOnly($doctor);


        $this->validate($request, [
            'group_id' => 'required|exists:group_therapists,id',
            "title" => "required|string|max:300",
            "desc" => "nullable|string|max:10000",
            "date" => "required|date_format:Y-m-d",
            "seats" => "required|integer",
            "start_time" => "required|date_format:H:i",
            "finish_time" => "required|date_format:H:i|after:start_time",
        ]);

        $data = $request->only('title', 'desc', 'date', 'seats', 'start_time', 'finish_time');

        $groupTherapist = GroupTherapist::where('user_id', $doctor->id)->where('id', $request->group_id)->first();

        $updated = $groupTherapist?->update($data);


        if (!$updated) {
            return $this->errorResponse("Group not found or does not belong to your groups", 404);
        }

        return $this->successResponse(message: "Your group updated successfully");
    }

    public function deletegroup(Request $request)
    {
        $doctor = auth()->user();
        $this->doctorOnly($doctor);

        $rules = [
            'group_id' => 'required|exists:group_therapists,id',
        ];


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->errorResponse("Group ID is required and must be belong to your groups", 400);
        }
        $deleted = GroupTherapist::where('id', $request->group_id)
            ->where('user_id', $doctor->id)
            ->delete();

        if (!$deleted) {
            return $this->errorResponse("Group not found or does not belong to your groups", 404);
        }

        return $this->successResponse(message: "Your group deleted successfully");
    }




    /*
     * Slots
     */
    public function slots(Request $request)
    {
        $doctor = auth()->user();
        $this->doctorOnly($doctor);

        $rules = [
            'date' => 'required|date_format:d-m-Y',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(
                [
                    'msg' => $validator->errors(),
                    'status' => false
                ],
                400
            );
        }

        $date = \Carbon\Carbon::parse($request->date);
        $dayName = $date->format('l');
        $slots = SlotRange::whereHas('slot', function ($query) use ($doctor) {
            $query->where('user_id', $doctor->id);
        })->where('day', $dayName)->get(['id', 'time_from', 'time_to', 'day']);

        return SlotRangeResource::collection($slots)->additional(['date' => $request->date]);
    }

    public function updateSlots(Request $request)
    {
        $doctor = auth()->user();
        $this->doctorOnly($doctor);



        $days = $request->days;

        $doctor->update(['time_zone_id' => $request->timezone_id]);


        // Start the transaction
        DB::beginTransaction();

        try {

            $doctor->doctorProfile?->update(['price' => $request->price]);
            Slot::where('user_id', $doctor->id)->delete();

            foreach ($days as $slot) {
                $day = Str::title($slot['day']);
                foreach ($slot['slots'] as $timeSlot) {
                    if (!empty($timeSlot['time_from']) && !empty($timeSlot['time_to'])) {

                        $validatedData = Validator::make([
                            'time_from' => $timeSlot['time_from'],
                            'time_to' => $timeSlot['time_to'],
                        ], [
                                'time_from' => 'required|regex:/^\d{1,2}:\d{1,2}(:\d{1,2})?$/',
                                'time_to' => 'required|regex:/^\d{1,2}:\d{1,2}(:\d{1,2})?$/|after:time_from',
                            ])->validate();

                        $validatedSlots[] = [
                            'time_from' => $validatedData['time_from'],
                            'time_to' => $validatedData['time_to'],
                            'day' => $slot['day'],
                        ];


                        // Convert time to UTC
                        $format = strlen($timeSlot['time_from']) > 5 ? 'H:i:s' : 'H:i';


                        $timeFromUTC = Carbon::parse($timeSlot['time_from'])->createFromFormat($format, $timeSlot['time_from'], $doctor->timeZone?->name)->setTimezone('UTC');

                        $timeToUTC = Carbon::parse($timeSlot['time_to'])->createFromFormat($format, $timeSlot['time_to'], $doctor->timeZone?->name)->setTimezone('UTC');

                        $doctorSlot = new Slot();
                        $doctorSlot->user_id = $doctor->id;
                        $doctorSlot->day = $day;
                        $doctorSlot->range = $request->range;
                        $doctorSlot->time_from = $timeFromUTC->format('H:i:s');
                        $doctorSlot->time_to = $timeToUTC->format('H:i:s');
                        $doctorSlot->save();


                        // Calculate time intervals
                        $interval = $request->range; // in minutes
                        $start = $timeFromUTC;
                        $end = $timeToUTC;
                        $ranges = [];
                        while ($start < $end) {
                            $ranges[] = [
                                'doctor_slot_id' => $doctorSlot->id,
                                'time_from' => $start->format('H:i:s'),
                                'time_to' => $start->addMinutes($interval)->format('H:i:s'),
                                'day' => $day,
                                'created_at' => now()
                            ];
                        }

                        // Insert data into slot_ranges table
                        DB::table('slot_ranges')->insert($ranges);
                    }
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        return $this->successResponse(message: "Your Slots updated successfully");
    }
    private function doctorOnly($user)
    {
        if ($user->user_type != "doctor") {
            abort($this->errorResponse('Please login with doctor account', 401));
        }
    }
}
