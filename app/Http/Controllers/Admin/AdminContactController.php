<?php

namespace App\Http\Controllers\Admin;

use App\Helper\DateHelper;
use Carbon\Carbon;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Spatie\Period\Period;

class AdminContactController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name   = $request->input('name');
        $email  = $request->input('email');
        $year   = $request->input('year');
        $month  = $request->input('month');
        $from   = null;
        if($year) {
            if($month) {
                $from = Carbon::createFromDate(year: $year, month: $month)->firstOfMonth();
            }
            else {
                $from = Carbon::createFromDate(year: $year)->firstOfYear();
            }
        }
        /*
         * @var Collection $data
         */
        $query = Contact::query()
            ->filter('name', $name)
            ->filter('email', $email)
            ->filterMonth('created_at', $month)
            ->filterYear('created_at', $year)
            ->orderBy('created_at','desc')
        ;
        $all = Contact::all();

        return view('admin.contacts.index', [
            'data'  => $query->paginate($this->paginatorLimit),
            'name'  => $name,
            'email' => $email,
            'year'  => $year,
            'month' => $month,
            'nameOptions'   => $all->keyBy('name')->map->name->prepend('Name wählen ...', null),
            'emailOptions'  => $all->keyBy('email')->map->email->prepend('Email wählen ...', null),
            'yearOptions'   => DateHelper::yearOptions($all, 'created_at'),
            'monthOptions'  => DateHelper::monthOptions($all, 'created_at'),
            'queryString'   => $request->only(['name','email','year', 'month']),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        try {
            $contact->delete();
            return redirect()->route('admin.contacts.index')->with('success', 'Kontakt-Anfrage erfolgreich gelöscht!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
