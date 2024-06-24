<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class JoinedGroupsResource extends JsonResource
{
    public function toArray($request)
    {
        $date =  Carbon::parse($this->date);

        $userTimeZone =  auth()->user()->timeZone?->name;
        $startTime =  Carbon::createFromFormat('H:i:s', $this->start_time, 'UTC')->setTimezone($userTimeZone);
        $finishTime = Carbon::createFromFormat('H:i:s', $this->finish_time, 'UTC')->setTimezone($userTimeZone);


        return [
            'id' => $this->id,
            'group_id' => 'GROUP_'.$this->id,
            'title' => $this->title,
            'date' => $date->format('d F Y'),
            'day' => $date->format('l'),
            'start_time' => $startTime->format('H:i'),
            'finish_time' => $finishTime->format('H:i'),
            'range' => $startTime->format('H:i') . ' - ' . $finishTime->format('H:i'),
            'duration' =>  $finishTime->diff($startTime)->h * 60

        ];
    }
}
