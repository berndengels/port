<?php

namespace App\Http\Controllers\Admin;

use App\Models\Houseboat;
use App\Http\Requests\HouseboatRequest;
use Illuminate\Http\Response;

class AdminHouseboatController extends AdminController
{
    protected $models;

    public function __construct()
    {
        parent::__construct();
        $this->models  = $this->houseboatModelRepository->options()->getSelectOptions();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = Houseboat::with('model')->paginate($this->paginatorLimit);
        return view('admin.houseboats.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param Houseboat $houseboat
     * @return Response
     */
    public function show(Houseboat $houseboat)
    {
        return view('admin.houseboats.show', compact('houseboat'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.houseboats.create', [
            'models'    => $this->models,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  HouseboatRequest  $request
     * @return Response
     */
    public function store(HouseboatRequest $request)
    {
        try {
            Houseboat::create($request->validated());
            return redirect()->route('admin.houseboats.index')->with('success', 'Hausboot erfolgreich angelegt!');
        } catch(Exception $e) {
            return redirect()->route('admin.houseboats.create', $request)->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Houseboat $houseboat
     * @return Response
     */
    public function edit(Houseboat $houseboat)
    {
        return view('admin.houseboats.edit', [
            'houseboat' => $houseboat,
            'models'    => $this->models,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  HouseboatRequest  $request
     * @param Houseboat $houseboat
     * @return Response
     */
    public function update(HouseboatRequest $request, Houseboat $houseboat)
    {
        try {
            $houseboat->update($request->validated());
            return redirect()->route('admin.houseboats.index')->with('success', 'Hausboot erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return redirect()->route('admin.houseboats.create', $request)->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Houseboat $houseboat
     * @return Response
     */
    public function destroy(Houseboat $houseboat)
    {
        try {
            $houseboat->delete();
            return redirect()->route('admin.houseboatModels.index')->with('success', 'Hausboot erfolgreich gelöscht!');
        } catch(Exception $e) {
            return redirect()->route('admin.houseboatModels.index')->with('error', $e->getMessage());
        }
    }
}
