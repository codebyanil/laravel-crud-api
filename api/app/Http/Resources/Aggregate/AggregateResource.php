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
            'story' => $this->story ?? 0,
            'contact' => $this->contact ?? 0,
        ];
    }

}
