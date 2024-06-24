<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\GroupTherapist;
use App\Http\Controllers\ApiController;

class RatingController extends ApiController
{

    public function rateDoctorGroup(Request $request, $groupId)
    {
        $this->validate($request, [
            'rate' => 'required|integer|max:5',
            'comment' => 'nullable|string|max:5000'
        ]);

        $groupTherapistExists = GroupTherapist::where('id', $groupId)->exists();
        if (!$groupTherapistExists) {
            return response()->json([
                'msg' => 'There is no group with ID ' . $groupId, 'status' => false
            ]);
        }

        $doctorId = GroupTherapist::where('id', $groupId)->value('user_id');
        $doctor = User::doctorType()->findOrFail($doctorId);
        $newRate = (int) $request->rate;

        $doctor->rateOnce(
            value: $newRate,
            comment: $request->comment ?? null,
            groupId: $groupId
        );

        $plur_star = $newRate > 1 ? ' stars ' : ' star ';
        return $this->successResponse('You Added ' . $newRate . $plur_star . 'to ' . $doctor->name);
    }

    public function rateDoctorBooking(Request $request, $bookingId)
    {
        $this->validate($request, [
            'rate' => 'required|integer|max:5',
            'comment' => 'nullable|string|max:5000'
        ]);

        $bookingExists = Booking::where('id', $bookingId)->exists();
        if (!$bookingExists) {
            return response()->json([
                'msg' => 'There is no booking with ID ' . $bookingId,                    'status' => false
            ]);
        }

        $doctorId = Booking::where('id', $bookingId)->value('doctor_id');
        $doctor = User::doctorType()->findOrFail($doctorId);
        $newRate = (int) $request->rate;

        $doctor->rateOnce(
            value: $newRate,
            comment: $request->comment ?? null,
            bookingId: $bookingId
        );

        $plur_star = $newRate > 1 ? ' stars ' : ' star ';
        return $this->successResponse('You Added ' . $newRate . $plur_star . 'to ' . $doctor->name);
    }
}
