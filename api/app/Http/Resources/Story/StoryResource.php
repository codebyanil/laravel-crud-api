<?php

namespace App\Http\Resources\Story;

use App\Http\Resources\BaseResource;
use Illuminate\Http\Request;

class StoryResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'member_id' => $this->member_id,
            'name' => $this->name,
            'title' => $this->title,
            'address' => $this->address,
            'description' => $this->description,
            'created_at' => $this->created_at
        ];
    }
}
