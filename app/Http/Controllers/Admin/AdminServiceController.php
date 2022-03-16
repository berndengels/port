<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use Illuminate\Http\Response;
use App\Http\Requests\ServiceRequest;

class AdminServiceController extends AdminController
{
    protected $categories;
    protected $materials;
    protected $priceTypes;

    public function __construct()
    {
        parent::__construct();
        $this->categories   = $this->serviceCategoryRepository->options()->getSelectOptions();
        $this->materials    = $this->materialRepository->options()->getSelectOptions();
        $this->priceTypes   = $this->configPriceTypeRepository->options()->getSelectOptions();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = Service::paginate($this->paginatorLimit);
        return view('admin.services.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Service  $service
     * @return Response
     */
    public function show(Service $service)
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
        return view('admin.services.create', [
            'categories'    => $this->categories,
            'materials'     => $this->materials,
            'priceTypes'    => $this->priceTypes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ServiceRequest  $request
     * @return Response
     */
    public function store(ServiceRequest $request)
    {
        try {
            Service::create($request->validated());
            return redirect()->route('admin.services.index')->with('success', 'Service erfolgreich angelegt!');
        } catch(Exception $e) {
            dd($e->getMessage());
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Service  $service
     * @return Response
     */
    public function edit(Service $service)
    {
        return view('admin.services.edit', [
            'service'       => $service,
            'categories'    => $this->categories,
            'materials'     => $this->materials,
            'priceTypes'    => $this->priceTypes,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ServiceRequest  $request
     * @param  Service  $service
     * @return Response
     */
    public function update(ServiceRequest $request, Service $service)
    {
        try {
            $validated = $request->validated();
            $service->update($validated);
            $materials = $validated['materials'] ?? null;
            if($materials && count($materials) > 0) {
                $service->materials()->sync($materials);
            }
            return redirect()->route('admin.services.index')->with('success', 'Service erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Service  $service
     * @return Response
     */
    public function destroy(Service $service)
    {
        try {
            $service->delete();
            return redirect()->route('admin.services.index')->with('success', 'Service erfolgreich gelöscht!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
