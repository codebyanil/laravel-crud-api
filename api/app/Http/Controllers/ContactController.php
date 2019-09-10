<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\DeleteRequest;
use App\Http\Requests\Contact\IndexRequest;
use App\Http\Requests\Contact\ShowRequest;
use App\Http\Requests\Contact\StoreRequest;
use App\Http\Requests\Contact\UpdateRequest;
use App\Http\Resources\Common\DeleteResource;
use App\Http\Resources\Contact\ContactResource;
use App\Models\Contact;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * --------------------------------------------------
     * Display a listing of the resource.
     *--------------------------------------------------
     * @return \Illuminate\Http\Response
     * --------------------------------------------------
     */
    public function index(IndexRequest $request, Contact $contact)
    {
        // allocate resources
        $perPage = $request->get('per_page');
        $sortOrder = $request->get('sort_order') ?? 'DESC';

        // init query builder
        $query = Contact::query();
        // sort and execute
        $query = $query->orderBy('contacts.id', $sortOrder);
        $contacts = $query->paginate($perPage ?: $query->count());

        return ContactResource::collection($contacts);
    }

    /**
     * --------------------------------------------------
     * Show the form for creating a new resource.
     *--------------------------------------------------
     * @return \Illuminate\Http\Response
     * --------------------------------------------------
     */
    public function create()
    {
        //
    }

    /**
     * --------------------------------------------------
     * Store a newly created resource in storage.
     *--------------------------------------------------
     * @param \Illuminate\Http\StoreRequest  $request
     * @return \Illuminate\Http\Response
     * --------------------------------------------------
     */
    public function store(StoreRequest $request)
    {
        $memberId = session()->get('member_id') ?? 7;

        $contact = new Contact();
        $contact->member_id = $memberId;
        $contact->name = $request->get('name');
        $contact->email = $request->get('email');
        $contact->address = $request->get('address');
        $contact->phone = $request->get('phone');
        $contact->save();
        return new ContactResource($contact);
    }

    /**
     * --------------------------------------------------
     * Display the specified resource.
     *--------------------------------------------------
     * @param  \Illuminate\Http\ShowRequest  $request
     * @param  intContact $contact)
     * @return \Illuminate\Http\Response
     * --------------------------------------------------
     */
    public function show(ShowRequest $request, Contact $contact)
    {
        return new ContactResource($contact);
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
     * @param  intContact $contact
     * @return \Illuminate\Http\Response
     * --------------------------------------------------
     */
    public function update(UpdateRequest $request,  Contact $contact)
    {
        $contact->name = $request->get('name') ?? $contact->name;
        $contact->email = $request->get('email') ?? $contact->email;
        $contact->address = $request->get('address') ?? $contact->address;
        $contact->phone = $request->get('phone') ?? $contact->phone;
        $contact->save();
        return new ContactResource($contact);
    }

    /**
     * --------------------------------------------------
     * Remove the specified resource from storage.
     *--------------------------------------------------
     *  @param  \Illuminate\Http\DeleteRequest  $request
     * @param  int Contact $contact
     * @return \Illuminate\Http\Response
     * --------------------------------------------------
     */
    public function destroy(DeleteRequest $request, Contact $contact)
    {
        if ($contact->delete()) {
            return new DeleteResource([]);
        }
        throw new AuthorizationException("forbidden you cannot delete contact");
    }
}
