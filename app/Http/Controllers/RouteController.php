<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class RouteController extends Controller
{
    protected $route;
    protected $startRoute;
    protected $currentName;
    protected $currentRoutes;

    public function setCurrentMenu(Request $request) {
        /**
         * @var $user User
         */
        $user = auth()->user();
        $this->route            = $request->input('route');
        $this->currentName      = $request->input('current');
        $this->currentRoutes    = collect(config('port.menu.admin.items.'.$this->currentName))
            ->filter(function ($item) use ($user) {
                return (!isset($item['permissions']) || (isset($item['permissions']) && $user->can($item['permissions'])));
            });
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
