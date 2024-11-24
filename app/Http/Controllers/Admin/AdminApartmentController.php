<?php

namespace App\Http\Controllers\Admin;

use App\Models\Apartment;
use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
use App\Models\ApartmentModel;
use Illuminate\Http\Response;

class AdminApartmentController extends AdminController
{
	private $models;

	public function __construct()
	{
		parent::__construct();
		$this->models  = $this->apartmentModelRepository->options()->getSelectOptions();
//		$this->models = ApartmentModel::select('id','name')->orderBy('name')->get()->keyBy('id')->map->name;
	}

	/**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = Apartment::paginate($this->paginatorLimit);
        return view('admin.apartments.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param Apartment $apartment
     * @return Response
     */
    public function show(Apartment $apartment)
    {
        return view('admin.apartments.show', compact('apartment'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.apartments.create', [
			'models' => $this->models,
		]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreApartmentRequest  $request
     * @return Response
     */
    public function store(StoreApartmentRequest $request)
    {
        try {
            Apartment::create($request->validated());
            return redirect()->route('admin.apartments.index')->with('success', 'Apartment erfolgreich angelegt!');
        } catch(Exception $e) {
            return redirect()->route('admin.apartments.create', $request)->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Apartment $apartment
     * @return Response
     */
    public function edit(Apartment $apartment)
    {
        return view('admin.apartments.edit', [
			'apartment'	=> $apartment,
			'models' => $this->models,
		]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateApartmentRequest  $request
     * @param Apartment $apartment
     * @return Response
     */
    public function update(UpdateApartmentRequest $request, Apartment $apartment)
    {
        try {
            $apartment->update($request->validated());
            return redirect()->route('admin.apartments.index')->with('success', 'Apartment erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return redirect()->route('admin.apartments.create', $request)->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Apartment $apartment
     * @return Response
     */
    public function destroy(Apartment $apartment)
    {
        try {
            $apartment->delete();
            return redirect()->route('admin.apartments.index')->with('success', 'Apartment erfolgreich gelöscht!');
        } catch(Exception $e) {
            return redirect()->route('admin.apartments.index')->with('error', $e->getMessage());
        }
    }
}
