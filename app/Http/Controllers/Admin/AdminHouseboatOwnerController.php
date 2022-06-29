<?php

namespace App\Http\Controllers\Admin;

use App\Models\HouseboatOwner;
use App\Http\Requests\StoreHouseboatOwnerRequest;
use App\Http\Requests\UpdateHouseboatOwnerRequest;
use Illuminate\Http\Response;

class AdminHouseboatOwnerController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = HouseboatOwner::paginate($this->paginatorLimit);
        return view('admin.houseboatOwners.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param HouseboatOwner $houseboatOwner
     * @return Response
     */
    public function show(HouseboatOwner $houseboatOwner)
    {
        return view('admin.houseboatOwners.show', compact('houseboatOwner'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.houseboatOwners.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreHouseboatOwnerRequest  $request
     * @return Response
     */
    public function store(StoreHouseboatOwnerRequest $request)
    {
        try {
            HouseboatOwner::create($request->validated());
            return redirect()->route('admin.houseboatOwners.index')->with('success', 'Hausboot-Eigentümer erfolgreich angelegt!');
        } catch(Exception $e) {
            return redirect()->route('admin.houseboatOwners.create', $request)->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param HouseboatOwner $houseboatOwner
     * @return Response
     */
    public function edit(HouseboatOwner $houseboatOwner)
    {
        return view('admin.houseboatOwners.edit', compact('houseboatOwner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateHouseboatOwnerRequest  $request
     * @param HouseboatOwner $houseboatOwner
     * @return Response
     */
    public function update(UpdateHouseboatOwnerRequest $request, HouseboatOwner $houseboatOwner)
    {
        try {
            $houseboatOwner->update($request->validated());
            return redirect()->route('admin.houseboatOwners.index')->with('success', 'Hausboot-Eigentümer erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return redirect()->route('admin.houseboatOwners.edit', $request)->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param HouseboatOwner $houseboatOwner
     * @return Response
     */
    public function destroy(HouseboatOwner $houseboatOwner)
    {
        try {
            $houseboatOwner->delete();
            return redirect()->route('admin.houseboatOwners.index')->with('success', 'Hausboot-Eigentümer erfolgreich gelöscht!');
        } catch(Exception $e) {
            return redirect()->route('admin.houseboatOwners.index')->with('error', $e->getMessage());
        }
    }
}
