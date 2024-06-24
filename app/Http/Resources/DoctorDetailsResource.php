<?php

namespace App\Http\Resources;

use App\Http\Resources\AgeGroupResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\SpecialtiesResource;
use App\Http\Resources\WorkingStylesResource;
use App\Http\Resources\QualificationsResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\SpeakingLanguagesResource;
use App\Models\SlotRange;

class DoctorDetailsResource extends JsonResource
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
            'surname' => $this->surname,
            'gender' => $this->gender,
            'phone' => $this->phone,
            'dob' => $this->dob,
            'yoe' => $this->doctorProfile->yoe,
            'price' => $this->doctorProfile->price,
            'ratings' => $this->usersRated(),
            'about' => $this->doctorProfile->about,
            'avatar' => $this->avatar,
            'intro_video' => $this->doctorProfile->intro_video,
            'cover_image' => $this->doctorProfile->cover_image,
            'passport' => $this->doctorProfile->passport,
            'license' => $this->doctorProfile->license,
            'categories' => CategoryResource::collection($this->categories),
            'age_groups' => AgeGroupResource::collection($this->ageGroups),
            'working_styles' => WorkingStylesResource::collection($this->workingStyles),
            'specialties' => SpecialtiesResource::collection($this->specialties),
            'qualifications' => QualificationsResource::collection($this->qualifications),
            'speaking_languages' => SpeakingLanguagesResource::collection($this->speakingLanguages),
            'slots' => SlotRangeResource::collection($this->slots),
        ];
    }
}
