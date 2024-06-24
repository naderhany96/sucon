<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorGroupItemsResource extends JsonResource
{

    public function toArray($request)
    {
        $date =  Carbon::parse($this->date);

        $userTimeZone =  auth()->user()->timeZone?->name;
        $startTime =  Carbon::createFromFormat('H:i:s', $this->start_time, 'UTC')->setTimezone($userTimeZone);
        $finishTime = Carbon::createFromFormat('H:i:s', $this->finish_time, 'UTC')->setTimezone($userTimeZone);

        $seatsTaken = $this->joiners?->count();
        $seatsAvailable = $this->seats - $seatsTaken;

        return [
            'id' => $this->id,
            'title' => $this->title,
            'short_desc' => Str::limit($this->desc, 110),
            'long_desc' => $this->desc,
            'date' => $date->format('d F Y'),
            'day' => $date->format('l'),
            'start_time' => $startTime->format('H:i'),
            'finish_time' => $finishTime->format('H:i'),
            'range' => $startTime->format('H:i') . ' - ' . $finishTime->format('H:i'),
            'duration' =>  $finishTime->diff($startTime)->h * 60,
            'seats' => $seatsTaken . '/' . $this->seats,
            'can_attend' => $seatsAvailable > 0 && ($date->isFuture() || ($date->isToday() && $startTime->isFuture())),
        ];
    }
}
