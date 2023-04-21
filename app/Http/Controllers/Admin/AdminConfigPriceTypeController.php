<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ConfigPriceTypeRequest;
use App\Models\ConfigPriceType;
use Illuminate\Http\Request;

class AdminConfigPriceTypeController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ConfigPriceType::paginate($this->paginatorLimit);
        return view('admin._config.priceTypes.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ConfigPriceType  $configPriceType
     * @return \Illuminate\Http\Response
     */
    public function show(ConfigPriceType $configPriceType)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ConfigPriceTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ConfigPriceTypeRequest $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ConfigPriceType  $configPriceType
     * @return \Illuminate\Http\Response
     */
    public function edit(ConfigPriceType $configPriceType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ConfigPriceTypeRequest  $request
     * @param  \App\Models\ConfigPriceType  $configPriceType
     * @return \Illuminate\Http\Response
     */
    public function update(ConfigPriceTypeRequest $request, ConfigPriceType $configPriceType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ConfigPriceType  $configPriceType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ConfigPriceType $configPriceType)
    {
        //
    }
}
