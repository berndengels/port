<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Response;
use App\Models\ServiceCategory;
use App\Http\Requests\ServiceCategoryRequest;

class AdminServiceCategoryController extends AdminController
{
    protected $priceTypes;

    public function __construct()
    {
        parent::__construct();
        $this->priceTypes = $this->priceTypeRepository->options()->getSelectOptions();
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = ServiceCategory::paginate($this->paginatorLimit);
        return view('admin.serviceCategories.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param  ServiceCategory  $serviceCategory
     * @return Response
     */
    public function show(ServiceCategory $serviceCategory)
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
        return view('admin.serviceCategories.create', [
            'priceTypes'    => $this->priceTypes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ServiceCategoryRequest  $request
     * @return Response
     */
    public function store(ServiceCategoryRequest $request)
    {
        try {
            ServiceCategory::create($request->validated());
            return redirect()->route('admin.serviceCategories.index')->with('success', 'Service Typ erfogreich angelegt!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ServiceCategory  $serviceCategory
     * @return Response
     */
    public function edit(ServiceCategory $serviceCategory)
    {
        return view('admin.serviceCategories.edit', [
            'serviceCategory' => $serviceCategory,
            'priceTypes' => $this->priceTypes,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ServiceCategoryRequest  $request
     * @param  ServiceCategory  $serviceCategory
     * @return Response
     */
    public function update(ServiceCategoryRequest $request, ServiceCategory $serviceCategory)
    {
        try {
            $serviceCategory->update($request->validated());
            return redirect()->route('admin.serviceCategories.index')->with('success', 'Service Typ erfogreich bearbeitet!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ServiceCategory  $serviceCategory
     * @return Response
     */
    public function destroy(ServiceCategory $serviceCategory)
    {
        try {
            $serviceCategory->delete();
            return redirect()->route('admin.serviceCategories.index')->with('success', 'Service Typ erfogreich gelösch!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
