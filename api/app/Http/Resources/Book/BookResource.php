<?php

namespace App\Http\Resources\Book;

use App\Http\Resources\BaseResource;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookResource extends BaseResource
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
            'user_id'=>$this->user_id,
            'name' => $this->name,
            'author' => $this->email,
            'address' => $this->address,
            'phone'=>$this->phone,
            'description'=>$this->phone,
            'created_at' => $this->created_at
        ];
    }
}