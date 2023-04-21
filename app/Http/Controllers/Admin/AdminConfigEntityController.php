<?php

namespace App\Http\Controllers\Admin;

use App\Helper\ModelHelper;
use App\Models\ConfigEntity;
use Illuminate\Http\Response;
use App\Http\Requests\StoreConfigEntityRequest;
use App\Http\Requests\UpdateConfigEntityRequest;
use App\Models\ConfigHasPriceComponent;

class AdminConfigEntityController extends AdminController
{
    protected $modelOptions;

    public function __construct()
    {
        parent::__construct();
        $this->modelOptions = ModelHelper::allPriceableModels()
            ->flip()
            ->map(fn($item) => __($item))
            ->prepend('Bitte wählen', null)
        ;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = ConfigEntity::with('priceComponents')->paginate($this->paginatorLimit);
        return view('admin._config.entities.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param ConfigEntity $entity
     * @return Response
     */
    public function show(ConfigEntity $entity)
    {
        return view('admin._config.entities.show', compact('entity'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin._config.entities.create', [
            'modelOptions'  => $this->modelOptions,
            'optionsPriceComponents'  => $this->configPriceComponentRepository->options()->getSelectOptions(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreConfigEntityRequest $request
     * @return Response
     */
    public function store(StoreConfigEntityRequest $request)
    {
        try {
            $entity = ConfigEntity::create($request->validated());
            $entity->priceComponents()->sync($request->validated()['priceComponents']);

            return redirect()->route('admin.config.entities.index')->with('success', 'Entity erfolgreich angelegt!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ConfigEntity $entity
     * @return Response
     */
    public function edit(ConfigEntity $entity)
    {
        $entity->load('priceComponents')->get();
        return view('admin._config.entities.edit', [
            'entity'  => $entity,
            'modelOptions'  => $this->modelOptions,
            'optionsPriceComponents'  => $this->configPriceComponentRepository->options()->getSelectOptions(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateConfigEntityRequest  $request
     * @param ConfigEntity $entity
     * @return Response
     */
    public function update(UpdateConfigEntityRequest $request, ConfigEntity $entity)
    {
        try {
            $entity->update($request->validated());
            $entity->priceComponents()->sync($request->validated()['priceComponents']);
            return redirect()->route('admin.config.entities.index')->with('success', 'Entity erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ConfigEntity $entity
     * @return Response
     */
    public function destroy(ConfigEntity $entity)
    {
        try {
            $entity->delete();
            return redirect()->route('admin.config.entities.index')->with('success', 'Entity erfolgreich gelöscht!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
