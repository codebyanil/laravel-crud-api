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
            'member_id'=>$this->member_id,
            'name' => $this->name,
            'author' => $this->author,
            'address' => $this->address,
            'phone'=>$this->phone,
            'description'=>$this->phone,
            'created_at' => $this->created_at
        ];
    }
}
