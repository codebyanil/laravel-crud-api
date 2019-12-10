<?php

namespace App\Http\Controllers;

use App\Http\Requests\Aggregate\CountRequest;
use App\Models\Contact;
use App\Models\Story;

class AggregateController extends Controller
{
    public function count(CountRequest $request)
    {
        $memberId = session()->get('member_id') ?? 7;
        return response(true, [
            'story' => Story::where('member_id', $memberId)->count(),
            'contact' => Contact::where('member_id', $memberId)->count(),
        ]);
    }
}
