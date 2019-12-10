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
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MemberController extends Controller
{
    /**
     * --------------------------------------------------
     * Display a listing of the resource.
     *--------------------------------------------------
     * @param IndexRequest $request
     * --------------------------------------------------
     * @return MemberResource|AnonymousResourceCollection
     */
    public function index(IndexRequest $request): AnonymousResourceCollection
    {

        // allocate resources
        $perPage = $request->get('per_page');
        $sortOrder = $request->get('sort_order') ?? 'DESC';

        // init query builder
        $query = Member::query();

        // search keyword
        if ($request->has('keyword') && strlen($request->get('keyword')) >= 2) {
            // search fields
            $searchFields = ['name', 'email'];
            $query->search($searchFields, $request->get('keyword'));
        }
        // sort and execute
        $query = $query->orderBy('members.id', $sortOrder);
        $members = $query->paginate($perPage ?: $query->count());

        return MemberResource::collection($members);
    }

    /**
     * --------------------------------------------------
     * Store a newly created resource in storage.
     *--------------------------------------------------
     * @param StoreRequest $request
     * @return MemberResource
     * --------------------------------------------------
     */
    public function store(StoreRequest $request): MemberResource
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
     * @param ShowRequest $request
     * @param Member $member
     * @return MemberResource
     * --------------------------------------------------
     */
    public function show(ShowRequest $request, Member $member): MemberResource
    {
        return new MemberResource($member);
    }


    /**
     * --------------------------------------------------
     * Update the specified resource in storage.
     * --------------------------------------------------
     * @param UpdateRequest $request
     * @param Member $member
     * @return MemberResource
     * --------------------------------------------------
     */
    public function update(UpdateRequest $request, Member $member): MemberResource
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
