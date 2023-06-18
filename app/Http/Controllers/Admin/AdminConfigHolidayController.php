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
