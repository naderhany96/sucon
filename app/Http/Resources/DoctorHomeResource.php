<?php

namespace App\Http\Resources;


use Carbon\Carbon;
use App\Models\Booking;
use App\Models\GroupTherapistUser;
use App\Http\Resources\BookingsResource;
use App\Http\Resources\GroupUserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorHomeResource extends JsonResource
{

    public function toArray($request)
    {

        $doctor = $this->resource;

        $myGroupsBookings = [
            "upcoming" => [],
            "history" => [],
        ];

        $mySlotsBookings = [
            "upcoming" => [],
            "history" => [],
        ];

        $userTimeZone = auth()->user()->timeZone?->name;
        $currentDate = Carbon::now()->toDateString();
        $currentDateTime = Carbon::now($userTimeZone)->toDateTimeString();


        //Retrieve my_groups_bookings
        $myGroupsUpcomingBookings = GroupTherapistUser::whereHas('group', function ($query) use ($currentDate, $currentDateTime, $doctor) {

            $query->where('user_id', $doctor->id)
                ->where('date', '>=', $currentDate)
                ->where(function ($query) use ($currentDate, $currentDateTime) {
                    $query->whereDate('date', '>', $currentDate)
                        ->orWhere(function ($query) use ($currentDate, $currentDateTime) {
                            $query->whereDate('date', '=', $currentDate)
                                ->whereTime('start_time', '>', $currentDateTime);
                        });
                });
        })->get();

        $myGroupsHistoryBookings = GroupTherapistUser::whereHas('group', function ($query) use ($currentDate, $currentDateTime, $doctor) {

            $query->where('user_id', $doctor->id)
                ->where('date', '<', $currentDate)
                ->where(function ($query) use ($currentDate, $currentDateTime) {
                    $query->whereDate('date', '<', $currentDate)
                        ->orWhere(function ($query) use ($currentDate, $currentDateTime) {
                            $query->whereDate('date', '=', $currentDate)
                                ->whereTime('start_time', '<=', $currentDateTime);
                        });
                });
        })->get();


        $myGroupsBookings['upcoming'] = GroupUserResource::collection($myGroupsUpcomingBookings);
        $myGroupsBookings['history'] = GroupUserResource::collection($myGroupsHistoryBookings);


        //Retrieve my_slots_bookings (group_therapists table)
        $mySlotsUpcomingBookings = Booking::where('doctor_id', $doctor->id)
            ->where('active', 1)
            ->where('date', '>=', $currentDate)
            ->where(function ($query) use ($currentDate, $currentDateTime) {
                $query->whereDate('date', '>', $currentDate)
                    ->orWhere(function ($query) use ($currentDate, $currentDateTime) {
                        $query->whereDate('date', '=', $currentDate)
                            ->whereTime('time_from', '>', $currentDateTime);
                    });
            })
            ->get();

        $mySlotsHistoryBookings = Booking::where('doctor_id', $doctor->id)
            ->where('active', 1)
            ->where('date', '<', $currentDate)
            ->orWhere(function ($query) use ($currentDate, $currentDateTime) {
                $query->where('date', '=', $currentDate)
                    ->whereTime('time_from', '<=', $currentDateTime);
            })
            ->get();


        $mySlotsBookings['upcoming'] = BookingsResource::collection($mySlotsUpcomingBookings);
        $mySlotsBookings['history'] = BookingsResource::collection($mySlotsHistoryBookings);

        return [
            "my_groups_bookings" => $myGroupsBookings,
            "my_slots_bookings" => $mySlotsBookings,
        ];

    }
}
