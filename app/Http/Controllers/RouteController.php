<?php
namespace App\Http\Controllers;

use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class RouteController extends Controller
{
    protected $route;

    public function setCurrentMenu($currentRouteName, Request $request)
    {
        $currentRoutes  = collect(config('port.menu.public.items.'.$currentRouteName));
        $this->route    = (!$this->route && isset($this->currentRoutes['items']) && count($this->currentRoutes['items']) && isset($this->currentRoutes['items'][0]['route'])) ? $this->currentRoutes['items'][0]['route'] : null;

        if($this->route && Route::getRoutes()->hasNamedRoute($this->route)) {
            $this->route = $this->route;
        }

        $request->session()->put('currentName', $currentRouteName);
        $request->session()->put('currentRoutes', $currentRoutes);
        $request->session()->put('currentRoute', $this->route);

        if($this->route) {
            return redirect()->route($this->route);
        } else {
            return redirect()->back();
        }
    }
}
