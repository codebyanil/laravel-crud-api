<?php

namespace App\Http\Controllers;

use App\Http\Requests\Aggregate\CountRequest;
use App\Http\Resources\Aggregate\AggregateResource;

class AggregateController extends Controller
{
    public function count(CountRequest $request)
    {
        return new AggregateResource($request);
    }
}
