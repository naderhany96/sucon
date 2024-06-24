<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupUserResource extends JsonResource
{

    public function toArray($request)
    {
        $date = Carbon::parse($this->group?->date);

        $userTimeZone = auth()->user()->timeZone?->name;
        $startTime = Carbon::createFromFormat('H:i:s', $this->group?->start_time, 'UTC')->setTimezone($userTimeZone);
        $finishTime = Carbon::createFromFormat('H:i:s', $this->group?->finish_time, 'UTC')->setTimezone($userTimeZone);

        $seatsTaken = $this->group?->joiners?->count();
        $seatsAvailable = $this->group?->seats - $seatsTaken;


        return [
            'id' => $this->id,
            'title' => $this->group?->title,
            'short_desc' => Str::limit($this->group?->desc, 110),
            'long_desc' => $this->group?->desc,
            'date' => $date->format('d F Y'),
            'day' => $date->format('l'),
            'start_time' => $startTime->format('H:i'),
            'finish_time' => $finishTime->format('H:i'),
            'range' => $startTime->format('H:i') . ' - ' . $finishTime->format('H:i'),
            'duration' => $finishTime->diff($startTime)->h * 60,
            'seats' => $seatsTaken . '/' . $this->group?->seats,
            'can_attend' => $seatsAvailable > 0 && ($date->isFuture() || ($date->isToday() && $startTime->isFuture())),
            'patient' => [
                $this->patient?->id,
                $this->patient?->surname,
                $this->patient?->name,
                $this->patient?->email,
            ],
        ];
    }
}
