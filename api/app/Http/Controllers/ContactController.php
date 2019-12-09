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
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ContactController extends Controller
{
    /**
     * --------------------------------------------------
     * Display a listing of the resource.
     *--------------------------------------------------
     * @param IndexRequest $request
     * @return  ContactResource|AnonymousResourceCollection
     * --------------------------------------------------
     */
    public function index(IndexRequest $request)
    {
        // allocate resources
        $perPage = $request->get('per_page');
        $sortOrder = $request->get('sort_order') ?? 'DESC';

        // init query builder
        $query = Contact::query();
        // search keyword
        if ($request->has('keyword') && strlen($request->get('keyword')) >= 2) {
            // search fields
            $searchFields = ['name', 'email', 'address', 'phone'];
            $query->search($searchFields, $request->get('keyword'));
        }
        // sort and execute
        $query = $query->orderBy('contacts.id', $sortOrder);
        $contacts = $query->paginate($perPage ?: $query->count());

        return ContactResource::collection($contacts);
    }


    /**
     * --------------------------------------------------
     * Store a newly created resource in storage.
     *--------------------------------------------------
     * @param StoreRequest $request
     * @return ContactResource
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
        $contact->dob = $request->input('dob');
        $contact->description = $request->input('description');
        $contact->photo_url = $request->input('photo_url');
        $contact->save();
        return new ContactResource($contact);
    }

    /**
     * --------------------------------------------------
     * Display the specified resource.
     *--------------------------------------------------
     * @param ShowRequest $request
     * @param Contact $contact
     * @return ContactResource
     * --------------------------------------------------
     */
    public function show(ShowRequest $request, Contact $contact)
    {
        return new ContactResource($contact);
    }

    /**
     * --------------------------------------------------
     * Update the specified resource in storage.
     *--------------------------------------------------
     * @param UpdateRequest $request
     * @param Contact $contact
     * @return ContactResource
     * --------------------------------------------------
     */
    public function update(UpdateRequest $request, Contact $contact)
    {
        $contact->name = $request->get('name') ?? $contact->name;
        $contact->email = $request->get('email') ?? $contact->email;
        $contact->address = $request->get('address') ?? $contact->address;
        $contact->phone = $request->get('phone') ?? $contact->phone;
        $contact->dob = $request->input('dob') ?? $contact->dob;
        $contact->description = $request->input('description') ?? $contact->description;
        $contact->photo_url = $request->input('photo_url') ?? $contact->photo_url;
        $contact->save();
        return new ContactResource($contact);
    }

    /**
     * --------------------------------------------------
     * Remove the specified resource from storage.
     *--------------------------------------------------
     * @param DeleteRequest $request
     * @param Contact $contact
     * @return DeleteResource
     * @throws AuthorizationException
     * --------------------------------------------------
     */
    public function destroy(DeleteRequest $request, Contact $contact)
    {
        if ($contact->delete()) {
            return new DeleteResource([]);
        }
        throw new AuthorizationException('Forbidden! You cannot delete this contact.');
    }
}
