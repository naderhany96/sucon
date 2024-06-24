<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DashboardDoctorResource extends JsonResource
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
            'name' => $this->name,
            'yoe' => $this->doctorProfile->yoe,
            'price' => $this->doctorProfile->price,
            'ratings' => $this->usersRated(),
            'avatar' => $this->avatar,
        ];
    }
}
