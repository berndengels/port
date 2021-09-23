<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class RouteController extends Controller
{
    protected $route;
    protected $startRoute;
    protected $currentName;
    protected $currentRoutes;

    public function setCurrentMenu(Request $request) {
        $this->route            = $request->input('route');
        $this->currentName      = $request->input('current');
        $this->currentRoutes    = config('port.menu.admin.items.'.$this->currentName);
        $this->startRoute       = (!$this->route && count($this->currentRoutes['items']) && isset($this->currentRoutes['items'][0]['route'])) ? $this->currentRoutes['items'][0]['route'] : null;
        if($this->route && Route::getRoutes()->hasNamedRoute($this->route)) {
            $this->startRoute = $this->route;
        }
        $request->session()->put('currentName', $this->currentName);
        $request->session()->put('currentRoutes', $this->currentRoutes);

        if($this->startRoute) {
            return redirect()->route($this->startRoute);
        } else {
            return redirect()->back();
        }
    }
}
