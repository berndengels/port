<?php

namespace App\Http\Controllers;

use App\Models\Caravan;
use App\Models\CaravanDates;
use App\Models\Widget;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;

class DashboardController extends Controller
{

    public function show()
    {
        $widgets = Widget::orderBy('position')->get();
        return view('public.dashboard', compact('widgets'));
    }
}
