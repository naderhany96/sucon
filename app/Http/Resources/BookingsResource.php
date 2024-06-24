<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingsResource extends JsonResource
{

    public function toArray($request)
    {
        $date = Carbon::parse($this->date);

        $userTimeZone = auth()->user()->timeZone?->name;
        $timeFrom = Carbon::createFromFormat('H:i:s', $this->time_from, 'UTC')->setTimezone($userTimeZone);
        $timeTo = Carbon::createFromFormat('H:i:s', $this->time_to, 'UTC')->setTimezone($userTimeZone);


        return [
            'id' => $this->id,
            'date' => $date->format('d F Y'),
            'time_from' => $timeFrom->format('H:i'),
            'time_to' => $timeTo->format('H:i'),
            'price' => $this->price,
            'done' => $this->done,
            'day' => $date->format('l'),
            'range' => $timeFrom->format('H:i') . ' - ' . $timeTo->format('H:i'),
            'duration' => $timeTo->diff($timeFrom)->h * 60,
            'patient' => PatientProfileResource::make($this->patient)
        ];
    }
}
