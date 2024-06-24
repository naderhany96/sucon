<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class SlotRangeResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'time_from' => Carbon::parse($this->time_from)->setTimezone(auth()->user()->timeZone?->name)->format('H:i'),
            'time_to' => Carbon::parse($this->time_to)->setTimezone(auth()->user()->timeZone?->name)->format('H:i'),
            'available' => true,
        ];
    }
}
