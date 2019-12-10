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
    public function index(IndexRequest $request)
    {
        // allocate resources
        $perPage = $request->get('per_page');
        $sortOrder = $request->get('sort_order') ?? 'DESC';

        // init query builder
        $query = Story::query();
        // search the keyword
        if ($request->has('keyword') && strlen($request->get('keyword')) >= 2) {
            // search fields
            $searchFields = ['name', 'title', 'address', 'description'];
            $query->search($searchFields, $request->get('keyword'));
        }
        // sort and execute
        $query = $query->orderBy('id', $sortOrder);
        $books = $query->paginate($perPage ?: $query->count());

        return StoryResource::collection($books);
    }


    /**
     * --------------------------------------------------
     * Store a newly created resource in storage.
     *--------------------------------------------------
     * @param StoreRequest $request
     * @return StoryResource
     * --------------------------------------------------
     */
    public function store(StoreRequest $request)
    {
        $memberId = session()->get('member_id') ?? 7;

        $book = new Story();
        $book->member_id = $memberId;
        $book->name = $request->get('name');
        $book->title = $request->get('title');
        $book->address = $request->get('address');
        if ($request->has('description')) {
            $book->description = $request->get('description');
        }
        $book->save();
        return new StoryResource($book);
    }

    /**
     * --------------------------------------------------
     * Display the specified resource.
     *--------------------------------------------------
     * @param ShowRequest $request
     * @param Story $book
     * @return StoryResource
     * --------------------------------------------------
     */
    public function show(ShowRequest $request, Story $book)
    {
        return new StoryResource($book);
    }


    /**
     * --------------------------------------------------
     * Update the specified resource in storage.
     *--------------------------------------------------
     * @param UpdateRequest $request
     * @param Story $book
     * @return StoryResource
     * --------------------------------------------------
     */
    public function update(UpdateRequest $request, Story $book)
    {
        $book->name = $request->get('name') ?? $book->name;
        $book->title = $request->get('title') ?? $book->title;
        $book->phone = $request->get('phone') ?? $book->phone;
        $book->address = $request->get('address') ?? $book->address;
        $book->description = $request->get('name') ?? $book->description;
        $book->save();
        return new StoryResource($book);
    }

    /**
     * --------------------------------------------------
     * Remove the specified resource from storage.
     *--------------------------------------------------
     * @param Story $book
     * @param DeleteRequest $request
     * @return DeleteResource
     * @throws AuthorizationException
     * --------------------------------------------------
     */
    public function destroy(DeleteRequest $request, Story $book)
    {
        if ($book->delete()) {
            return new DeleteResource([]);
        }
        throw new AuthorizationException('Forbidden! You cannot delete this book.');
    }
}
