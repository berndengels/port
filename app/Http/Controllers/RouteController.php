<?php
namespace App\Http\Controllers;

use App\Models\AdminUser;
use Detection\MobileDetect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class RouteController extends Controller
{
    protected $route;
    protected $subRoute;
    protected $subActions = ['show','edit','update','create','store','destroy'];

    public function setCurrentMenu(string $guard, string $currentRouteName, string $route, Request $request)
    {
        $isMobile = (new MobileDetect())->isMobile();
        $currentRoutes = [];
        $routes = collect(config('port.menu.'.$guard.'.items.'.$currentRouteName));
        if(isset($routes['items']) && is_array($routes['items']) && count($routes['items']) > 0) {
            $currentRoutes['items'] = collect($routes['items'])->filter(fn($item) => (
                !$isMobile
                || ($isMobile && ! $item['hide_on_mobile'])
            ));
        }
/*
        if(isset($currentRoutes['route'])) {
            $this->route = $currentRoutes['route'];
        }
        elseif(isset($currentRoutes['items']) && count($currentRoutes['items']) > 0 && isset($currentRoutes['items'][0]['route'])) {
            $this->route = $currentRoutes['items'][0]['route'];
        }
*/
        if($route) {
            $this->route = $route;
        }

        $request->session()->put('currentRoutes', $currentRoutes);
        $request->session()->put('currentRoute', $this->route);

        if($this->route && Route::getRoutes()->hasNamedRoute($this->route)) {
            return redirect()->route($this->route);
        } else {
            return redirect()->back();
        }
    }
}
