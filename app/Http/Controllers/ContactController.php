<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Http\Requests\StoreContactRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\Contact as ContactMail;

class ContactController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        return view('public.contacts.show', compact('contact'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('public.contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param   $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContactRequest $request)
    {
        try {
            $contact = Contact::create($request->validated());
            Mail::send(new ContactMail($contact));
            return redirect()->route('public.contacts.show', $contact)->with(['success' => "Kontakt-Anfrage erfolgreich versandt"]);
        } catch(Exception $e) {
            return back()->with(['error' => $e->getMessage()]);
        }
    }
}
