<?php

namespace App\Http\Resources\Contact;

use App\Http\Resources\BaseResource;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ContactResource extends BaseResource
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
            'email' => $this->email,
            'address' => $this->address,
            'phone'=>$this->phone,
            'created_at' => $this->created_at
        ];
    }
}