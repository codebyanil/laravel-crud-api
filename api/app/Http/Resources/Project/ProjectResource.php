<?php

namespace App\Http\Resources\Project;

use App\Http\Resources\BaseResource;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProjectResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'member_id'=>$this->member_id,
            'name' => $this->name,
            'url' => $this->url,
            'description' => $this->description,
            'created_at' => $this->created_at
        ];
    }
}