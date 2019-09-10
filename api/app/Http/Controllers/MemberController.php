<?php

namespace App\Http\Controllers;

use App\Http\Requests\Member\DeleteRequest;
use App\Http\Requests\Member\IndexRequest;
use App\Http\Requests\Member\ShowRequest;
use App\Http\Requests\Member\StoreRequest;
use App\Http\Requests\Member\UpdateRequest;
use App\Http\Resources\Common\DeleteResource;
use App\Http\Resources\Member\MemberResource;
use App\Models\Member;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * --------------------------------------------------
     * Display a listing of the resource.
     *--------------------------------------------------
     * @return \Illuminate\Http\Response
     * @param  \Illuminate\Http\IndexRequest  $request
     * --------------------------------------------------
     */
    public function index(IndexRequest $request)
    {

        // allocate resources
        $perPage = $request->get('per_page');
        $sortOrder = $request->get('sort_order') ?? 'DESC';

        // init query builder
        $query = Member::query();
        // sort and execute
        $query = $query->orderBy('members.id', $sortOrder);
        $members = $query->paginate($perPage ?: $query->count());

        return MemberResource::collection($members);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * --------------------------------------------------
     * Store a newly created resource in storage.
     *--------------------------------------------------
     * @param  \Illuminate\Http\StoreRequest  $request
     * @return \Illuminate\Http\Response
     * --------------------------------------------------
     */
    public function store(StoreRequest $request)
    {
        // create user
        $user = new Member([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
        ]);
        $user->save();

        return new MemberResource($user);
    }

    /**
     * --------------------------------------------------
     * Display the specified resource.
     *--------------------------------------------------
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * --------------------------------------------------
     */
    public function show(ShowRequest $request, Member $member)
    {
        return new MemberResource($member);
    }

    /**
     * --------------------------------------------------
     * Show the form for editing the specified resource.
     *--------------------------------------------------
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * --------------------------------------------------
     */
    public function edit($id)
    {
        //
    }

    /**
     * --------------------------------------------------
     * Update the specified resource in storage.
     * --------------------------------------------------
     * @param  \Illuminate\Http\UpdateRequest  $request
     * @param  int  Member $member
     * @return \Illuminate\Http\Response
     * --------------------------------------------------
     */
    public function update(UpdateRequest $request, Member $member)
    {

        $member->name = $request->get('name') ?? $member->name;
        $member->email = $request->get('email') ?? $member->email;
        $member->save();
        return new MemberResource($member);
    }

    /**
     * --------------------------------------------------
     * Remove the specified resource from storage.
     *--------------------------------------------------
     * @param DeleteRequest $request
     * @param Member $member
     * @return DeleteResource
     * @throws AuthorizationException
     * @return \Illuminate\Http\Response
     * --------------------------------------------------
     */
    public function destroy(DeleteRequest $request, Member $member)
    {
        if ($member->delete()) {
            return new DeleteResource([]);
        }
        throw new AuthorizationException('Forbidden! You cannot delete this member.');
    }
}
