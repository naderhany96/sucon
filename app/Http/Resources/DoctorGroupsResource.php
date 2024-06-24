<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorGroupsResource extends JsonResource
{


    public function toArray($request)
    {
        return [
            "surname" => $this->surname,
            "name" => $this->name,
            "avatar" => $this->avatar,
            "cover_image" => $this->doctorProfile?->cover_image,
            "group_therapists" => DoctorGroupItemsResource::collection($this->groupTherapists),
        ];
    }
}
