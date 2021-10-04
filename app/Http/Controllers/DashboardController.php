<?php

namespace App\Http\Controllers;

use App\Models\Caravan;
use App\Models\CaravanDates;
use App\Models\Widget;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $caravansFromToday;

    public function __construct()
    {
    }

    public function show() {
        $widgets = Widget::orderBy('position')->get();
        return view('public.dashboard', compact('widgets'));
    }
}
