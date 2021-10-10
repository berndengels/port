<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;

class AdminRouteController extends AdminController
{
    protected $route;
    protected $pregRoutesExcept = '/^(_|team)/i';

    public function setCurrentMenu($currentRouteName, Request $request) {
        $currentRoutes = config('port.menu.admin.items.'.$currentRouteName);

        if(isset($currentRoutes['route'])) {
            $this->route = $currentRoutes['route'];
        }
        elseif(isset($currentRoutes['items']) && count($currentRoutes['items']) > 0 && isset($currentRoutes['items'][0]['route'])) {
            $this->route = $currentRoutes['items'][0]['route'];
        }
        $request->session()->put('currentName', $currentRouteName);
        $request->session()->put('currentRoutes', $currentRoutes);
        $request->session()->put('currentRoute', $this->route);

        if($this->route && Route::getRoutes()->hasNamedRoute($this->route)) {
            return redirect()->route($this->route);
        } else {
            return redirect()->back();
        }
    }

    public function routes(Request $request)
    {
        $routeName = $request->post('routeName');
        $data = collect([]);
        /**
         * @var $route \Illuminate\Routing\Route
         */
        foreach(Route::getRoutes() as $route) {
            if( !preg_match($this->pregRoutesExcept, $route->uri) ) {
                $data->push($route);
            }
        }

        if($routeName) {
            $data = $data->filter(function($item) use ($routeName) {
                return (isset($item->action['as']) && false !== stristr($item->action['as'], $routeName));
            });
        }
        return view('admin.routes.index', compact('data','routeName'));
    }
}
