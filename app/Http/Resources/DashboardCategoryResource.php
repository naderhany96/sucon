<?php

namespace App\Http\Resources;

use App\Http\Resources\CategoryChildrenResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardCategoryResource extends JsonResource
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
            'image' => $this->image,
            'sub_categories' => CategoryChildrenResource::collection($this->children),
        ];
    }
}
