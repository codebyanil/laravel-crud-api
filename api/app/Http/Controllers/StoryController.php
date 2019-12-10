<?php

namespace App\Http\Controllers;

use App\Http\Requests\Story\DeleteRequest;
use App\Http\Requests\Story\IndexRequest;
use App\Http\Requests\Story\ShowRequest;
use App\Http\Requests\Story\StoreRequest;
use App\Http\Requests\Story\UpdateRequest;
use App\Http\Resources\Common\DeleteResource;
use App\Http\Resources\Story\StoryResource;
use App\Models\Story;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class StoryController extends Controller
{
    /**
     *  --------------------------------------------------
     * Display a listing of the resource.
     *
     *  --------------------------------------------------
     * @param IndexRequest $request
     * @return StoryResource| AnonymousResourceCollection
     *  --------------------------------------------------
     */
    public function index(IndexRequest $request): AnonymousResourceCollection
    {
        // allocate resources
        $perPage = $request->get('per_page');
        $sortOrder = $request->get('sort_order') ?? 'DESC';

        // init query builder
        $query = Story::query();

        // date range
        if ($request->has('start_date') || $request->has('end_date')) {

            $start = Carbon::parse($request->input('start_date'))->startOfDay();
            $end = Carbon::parse($request->input('end_date'))->endOfDay();

            //date filter
            $query->whereBetween('created_at', [$start, $end]);
        }
        // search the keyword
        if ($request->has('keyword') && strlen($request->get('keyword')) >= 2) {
            // search fields
            $searchFields = ['name', 'title', 'address', 'description'];
            $query->search($searchFields, $request->get('keyword'));
        }
        // sort and execute
        $query = $query->orderBy('id', $sortOrder);
        $stories = $query->paginate($perPage ?: $query->count());

        return StoryResource::collection($stories);
    }


    /**
     * --------------------------------------------------
     * Store a newly created resource in storage.
     *--------------------------------------------------
     * @param StoreRequest $request
     * @return StoryResource
     * --------------------------------------------------
     */
    public function store(StoreRequest $request): StoryResource
    {
        $memberId = session()->get('member_id') ?? 7;

        $story = new Story();
        $story->member_id = $memberId;
        $story->name = $request->get('name');
        $story->title = $request->get('title');
        $story->address = $request->get('address');
        if ($request->has('description')) {
            $story->description = $request->get('description');
        }
        $story->save();
        return new StoryResource($story);
    }

    /**
     * --------------------------------------------------
     * Display the specified resource.
     *--------------------------------------------------
     * @param ShowRequest $request
     * @param Story $story
     * @return StoryResource
     * --------------------------------------------------
     */
    public function show(ShowRequest $request, Story $story): StoryResource
    {
        return new StoryResource($story);
    }


    /**
     * --------------------------------------------------
     * Update the specified resource in storage.
     *--------------------------------------------------
     * @param UpdateRequest $request
     * @param Story $story
     * @return StoryResource
     * --------------------------------------------------
     */
    public function update(UpdateRequest $request, Story $story): StoryResource
    {
        $story->name = $request->get('name') ?? $story->name;
        $story->title = $request->get('title') ?? $story->title;
        $story->address = $request->get('address') ?? $story->address;
        $story->description = $request->get('name') ?? $story->description;
        $story->save();
        return new StoryResource($story);
    }

    /**
     * --------------------------------------------------
     * Remove the specified resource from storage.
     *--------------------------------------------------
     * @param DeleteRequest $request
     * @param Story $story
     * @return DeleteResource
     * @throws AuthorizationException
     * --------------------------------------------------
     */
    public function destroy(DeleteRequest $request, Story $story)
    {
        if ($story->delete()) {
            return new DeleteResource([]);
        }
        throw new AuthorizationException('Forbidden! You cannot delete this book.');
    }
}
