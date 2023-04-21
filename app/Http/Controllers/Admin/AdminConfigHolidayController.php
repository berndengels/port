<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConfigHoliday;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdminConfigHolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = ConfigHoliday::paginate($this->paginatorLimit);
        return view('admin._config.holidays.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param ConfigHoliday $configHoliday
     * @return Response
     */
    public function show(ConfigHoliday $configHoliday)
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ConfigHoliday $configHoliday
     * @return Response
     */
    public function edit(ConfigHoliday $configHoliday)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param ConfigHoliday $configHoliday
     * @return Response
     */
    public function update(Request $request, ConfigHoliday $configHoliday)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ConfigHoliday $configHoliday
     * @return Response
     */
    public function destroy(ConfigHoliday $configHoliday)
    {
        //
    }

    public function toggle(ConfigHoliday $configHoliday, Request $request)
    {
        if($request->isXmlHttpRequest()) {
            $attribute  = $request->post('attribute');
            $value      = (bool) $request->post('value');
            $configHoliday->update([$attribute => $value]);
            $configHoliday->refresh();
            return response()->json($configHoliday);
        }
        return response()->json(['error' => 'no ajax request']);
    }
}
