<?php

namespace App\Http\Controllers;

use App\Models\Widget;
use App\Models\HouseboatRentals;

class DashboardController extends Controller
{

    public function show()
    {
        $widgets = Widget::orderBy('position')->get();
        return view('public.dashboard', compact('widgets'));
    }
}
