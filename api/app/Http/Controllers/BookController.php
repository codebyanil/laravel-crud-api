<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\DeleteRequest;
use App\Http\Requests\Book\IndexRequest;
use App\Http\Requests\Book\ShowRequest;
use App\Http\Requests\Book\StoreRequest;
use App\Http\Requests\Book\UpdateRequest;
use App\Http\Resources\Book\BookResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Resources\Common\DeleteResource;
use App\Models\Book;
use Illuminate\Auth\Access\AuthorizationException;

class BookController extends Controller
{
    /**
     *  --------------------------------------------------
     * Display a listing of the resource.
     *
     *  --------------------------------------------------
     * @param IndexRequest $request
     * @return BookResource| AnonymousResourceCollection
     *  --------------------------------------------------
     */
    public function index(IndexRequest $request)
    {
        // allocate resources
        $perPage = $request->get('per_page');
        $sortOrder = $request->get('sort_order') ?? 'DESC';

        // init query builder
        $query = Book::query();
        // search the keyword
        if ($request->has('keyword') && strlen($request->get('keyword')) >= 2) {
            // search fields
            $searchFields = ['name', 'author', 'address', 'phone'];
            $query->search($searchFields, $request->get('keyword'));
        }
        // sort and execute
        $query = $query->orderBy('books.id', $sortOrder);
        $books = $query->paginate($perPage ?: $query->count());

        return BookResource::collection($books);
    }


    /**
     * --------------------------------------------------
     * Store a newly created resource in storage.
     *--------------------------------------------------
     * @param StoreRequest $request
     * @return BookResource
     * --------------------------------------------------
     */
    public function store(StoreRequest $request)
    {
        $memberId = session()->get('member_id') ?? 7;

        $book = new Book();
        $book->member_id = $memberId;
        $book->name = $request->get('name');
        $book->author = $request->get('author');
        $book->address = $request->get('address');
        $book->phone = $request->get('phone');
        if ($request->has('description')) {
            $book->description = $request->get('description');
        }
        $book->save();
        return new BookResource($book);
    }

    /**
     * --------------------------------------------------
     * Display the specified resource.
     *--------------------------------------------------
     * @param ShowRequest $request
     * @param Book $book
     * @return BookResource
     * --------------------------------------------------
     */
    public function show(ShowRequest $request, Book $book)
    {
        return new BookResource($book);
    }


    /**
     * --------------------------------------------------
     * Update the specified resource in storage.
     *--------------------------------------------------
     * @param UpdateRequest $request
     * @param Book $book
     * @return BookResource
     * --------------------------------------------------
     */
    public function update(UpdateRequest $request, Book $book)
    {
        $book->name = $request->get('name') ?? $book->name;
        $book->author = $request->get('author') ?? $book->author;
        $book->phone = $request->get('phone') ?? $book->phone;
        $book->address = $request->get('address') ?? $book->address;
        $book->description = $request->get('name') ?? $book->description;
        $book->save();
        return new BookResource($book);
    }

    /**
     * --------------------------------------------------
     * Remove the specified resource from storage.
     *--------------------------------------------------
     * @param Book $book
     * @param DeleteRequest $request
     * @return DeleteResource
     * @throws AuthorizationException
     * --------------------------------------------------
     */
    public function destroy(DeleteRequest $request, Book $book)
    {
        if ($book->delete()) {
            return new DeleteResource([]);
        }
        throw new AuthorizationException('Forbidden! You cannot delete this book.');
    }
}
