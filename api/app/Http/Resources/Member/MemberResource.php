<?php

namespace App\Http\Resources\Member;

use App\Http\Resources\BaseResource;
use Illuminate\Http\Request;

class MemberResource extends BaseResource
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
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $this->created_at
        ];
    }
}