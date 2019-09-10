<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\DeleteRequest;
use App\Http\Requests\Book\IndexRequest;
use App\Http\Requests\Book\ShowRequest;
use App\Http\Requests\Book\StoreRequest;
use App\Http\Requests\Book\UpdateRequest;
use App\Http\Resources\Book\BookResource;
use App\Http\Resources\Common\DeleteResource;
use App\Models\Book;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     *  --------------------------------------------------
     * Display a listing of the resource.
     *
     *  --------------------------------------------------
     * @param  \Illuminate\Http\IndexRequest $request
     * @return \Illuminate\Http\Response
     *  --------------------------------------------------
     */
    public function index(IndexRequest $request)
    {
        // allocate resources
        $perPage = $request->get('per_page');
        $sortOrder = $request->get('sort_order') ?? 'DESC';

        // init query builder
        $query = Book::query();
        // sort and execute
        $query = $query->orderBy('books.id', $sortOrder);
        $books = $query->paginate($perPage ?: $query->count());

        return BookResource::collection($books);
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
     * @param  \Illuminate\Http\ShowRequest  $request
     * @param  intBook $book
     * @return \Illuminate\Http\Response
     * --------------------------------------------------
     */
    public function show(ShowRequest $request, Book $book)
    {
        return  new BookResource($book);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * --------------------------------------------------
     * Update the specified resource in storage.
     *--------------------------------------------------
     * @param  \Illuminate\Http\UpdateRequest  $request
     * @param  intBook $book
     * @return \Illuminate\Http\Response
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
        return  new BookResource($book);
    }

    /**
     * --------------------------------------------------
     * Remove the specified resource from storage.
     *--------------------------------------------------
     * @param  intBook $book
     * @param  \Illuminate\Http\DeleteRequest  $request
     * @return \Illuminate\Http\Response
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
