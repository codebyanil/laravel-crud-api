<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
    protected $space;
    protected $identity;

    public function __construct($resource, $wrap = false)
    {
        parent::__construct($resource);
        // data wrapper
        static::$wrap = $wrap ? 'data' : null;
    
    }

    /**
     * Transform the resource into an array.
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }

    /**
     * --------------------------------------------------
     * cast the given time to 12HR format.
     * --------------------------------------------------
     * @param string|null $time
     * @return string|null
     * --------------------------------------------------
     */
    protected function formatTime($time)
    {
        try {
            $dateTime = new \DateTime($time);
            return $dateTime->format('h:i A');
        } catch (\Exception $exception) {
            return null;
        }
    }
}
