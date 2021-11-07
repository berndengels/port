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

        if(isset($currentRoutes['route'])) {
            $this->route = $currentRoutes['route'];
        }
        elseif(isset($currentRoutes['items']) && count($currentRoutes['items']) > 0 && isset($currentRoutes['items'][0]['route'])) {
            $this->route = $currentRoutes['items'][0]['route'];
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
