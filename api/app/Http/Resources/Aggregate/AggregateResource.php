<?php


namespace App\Http\Resources\Aggregate;

use App\Http\Resources\BaseResource;
use Illuminate\Http\Request;

class AggregateResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'user' => $this->user ?? 0,
            'book' => $this->book ?? 0,
            'project' => $this->project ?? 0,
        ];
    }

}
