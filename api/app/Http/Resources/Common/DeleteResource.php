<?php

namespace App\Http\Resources\Common;

use App\Http\Resources\BaseResource;
use Illuminate\Http\Request;

class DeleteResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'message' => isset($this->message) ? $this->message : ($this['message'] ?? 'The resource is archived or deleted.')
        ];
    }
}