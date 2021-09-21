<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    protected $current;

    public function setCurrentMenu(Request $request) {
/*
        Inertia::share('currentMenu', function () use ($request) {
            return $request->post('current');
        });
*/
        Inertia::share('currentMenu', $request->post('current'));
        return Inertia::getShared('currentMenu');
    }
}
