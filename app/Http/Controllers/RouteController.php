<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    protected $currentName;
    protected $currentRoutes;

    public function setCurrentMenu($current, Request $request) {
        $this->currentName = $current;
        $request->session()->put('currentName', $this->currentName);
        $request->session()->put('currentRoutes', config('port.menu.admin.items.'.$this->currentName));
        return redirect()->back();
    }
}
