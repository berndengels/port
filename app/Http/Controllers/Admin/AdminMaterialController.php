<?php

namespace App\Http\Controllers\Admin;

use App\Models\Material;
use Illuminate\Http\Response;
use App\Http\Requests\MaterialRequest;


class AdminMaterialController extends AdminController
{
    protected $categories;
    protected $priceTypes;
    protected $fertilityUnits;
    protected $fertilityPers;

    public function __construct()
    {
        parent::__construct();
        $this->categories = $this->materialCategoryRepository->options()->getSelectOptions();
        $this->priceTypes = $this->configPriceTypeRepository->options()->getSelectOptions();
        $this->fertilityUnits = config('port.prices.fertility.units');
        $this->fertilityPers = config('port.prices.fertility.per');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = Material::paginate($this->paginatorLimit);
        return view('admin.materials.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Material  $material
     * @return Response
     */
    public function show(Material $material)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.materials.create', [
            'categories'        => $this->categories,
            'priceTypes'        => $this->priceTypes,
            'fertilityPers'     => $this->fertilityPers,
            'fertilityUnits'    => $this->fertilityUnits,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MaterialRequest  $request
     * @return Response
     */
    public function store(MaterialRequest $request)
    {
        try {
            Material::create($request->validated());
            return redirect()->route('admin.materials.index')->with('success', 'Material erfolgreich angelegt!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Material  $material
     * @return Response
     */
    public function edit(Material $material)
    {
        return view('admin.materials.edit', [
            'material'          => $material,
            'categories'        => $this->categories,
            'priceTypes'        => $this->priceTypes,
            'fertilityPers'     => $this->fertilityPers,
            'fertilityUnits'    => $this->fertilityUnits,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MaterialRequest  $request
     * @param  Material  $material
     * @return Response
     */
    public function update(MaterialRequest $request, Material $material)
    {
        try {
            $material->update($request->validated());
            return redirect()->route('admin.materials.index')->with('success', 'Material erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Material $material
     * @return Response
     */
    public function destroy(Material $material)
    {
        try {
            $material->delete();
            return redirect()->route('admin.materials.index')->with('success', 'Material erfolgreich gelöscht!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
        //
    }
}
