<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Response;
use App\Models\MaterialCategory;
use App\Http\Requests\MaterialCategoryRequest;

class AdminMaterialCategoryController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = MaterialCategory::paginate($this->paginatorLimit);
        return view('admin.materialCategories.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param  MaterialCategory  $materialCategory
     * @return Response
     */
    public function show(MaterialCategory $materialCategory)
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
        $modi = config('port.main.boat.material.modi');
        return view('admin.materialCategories.create',compact('modi'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MaterialCategoryRequest $request
     * @return Response
     */
    public function store(MaterialCategoryRequest $request)
    {
        try {
            MaterialCategory::create($request->validated());
            return redirect()->route('admin.materialCategories.index')->with('success', 'Material Typ erfolgreich angelegt!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  MaterialCategory $materialCategory
     * @return Response
     */
    public function edit(MaterialCategory $materialCategory)
    {
        $modi = config('port.main.boat.material.modi');
        return view('admin.materialCategories.edit', compact('materialCategory','modi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MaterialCategoryRequest  $request
     * @param  MaterialCategory  $materialCategory
     * @return Response
     */
    public function update(MaterialCategoryRequest $request, MaterialCategory $materialCategory)
    {
        try {
            $materialCategory->update($request->validated());
            return redirect()->route('admin.materialCategories.index')->with('success', 'Material Typ erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  MaterialCategory $materialCategory
     * @return Response
     */
    public function destroy(MaterialCategory $materialCategory)
    {
        try {
            $materialCategory->delete();
            return redirect()->route('admin.materialCategories.index')->with('success', 'Material Typ erfolgreich gelöscht!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
