<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    protected $route;
    protected $currentName;
    protected $currentRoutes;

    public function setCurrentMenu(Request $request) {
        $this->currentName = $request->input('current');
        $this->route = $request->input('route');

        $request->session()->put('currentName', $this->currentName);
        $request->session()->put('currentRoutes', config('port.menu.admin.items.'.$this->currentName));

        if($this->route && Route::getRoutes()->hasNamedRoute($this->route)) {
            return redirect()->route($this->route);
        } else {
            return redirect()->back();
        }
    }
}
