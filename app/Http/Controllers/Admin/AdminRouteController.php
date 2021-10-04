<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;

class AdminRouteController extends AdminController
{
    protected $route;
    protected $currentName;
    protected $currentRoutes;
    protected $pregRoutesExcept = '/^(_|team)/i';

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
