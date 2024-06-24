<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BookedSlotResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $timeFrom = Carbon::parse($this->time_from)->setTimezone(auth()->user()->timeZone?->name);

        $timeTo = Carbon::parse($this->time_to)->setTimezone(auth()->user()->timeZone?->name);
        return [
            'id' => $this->id,
            'meeting_id' => 'MEETING_' . $this->id,
            'time_from' => $timeFrom->format('H:i'),
            'time_to' => $timeTo->format('H:i'),
            'duration' => $timeTo->diff($timeFrom)->h * 60,
            'day' => Carbon::parse($this->date)->format('l'),
            'date' => Carbon::parse($this->date)->format('Y-m-d'),
            'doctor_name' => $this->doctor->name,
            'doctor_surname' => $this->doctor->surname,
            'doctor_avatar' => $this->doctor->avatar,
        ];
    }
}
