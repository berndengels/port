<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;

class AdminRouteController extends AdminController
{
    protected $route;
    protected $subRoute;
    protected $subActions = ['show','edit','update','create','store','destroy'];
/*
    public function setCurrentMenu($currentRouteName, Request $request)
    {
        $currentRoutes = config('port.menu.admin.items.'.$currentRouteName);

        if(isset($currentRoutes['route'])) {
            $this->route = $currentRoutes['route'];
        }
        elseif(isset($currentRoutes['items']) && count($currentRoutes['items']) > 0 && isset($currentRoutes['items'][0]['route'])) {
            $this->route = $currentRoutes['items'][0]['route'];
        }

        $request->session()->put('currentRoutes', $currentRoutes);
        $request->session()->put('currentRoute', $this->route);

        if($this->route && Route::getRoutes()->hasNamedRoute($this->route)) {
            return redirect()->route($this->route);
        } else {
            return redirect()->back();
        }
    }
*/
}
