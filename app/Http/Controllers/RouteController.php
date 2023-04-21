<?php
namespace App\Http\Controllers;

use Detection\MobileDetect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class RouteController extends Controller
{
    public function setCurrentMenu(string $guard, string $currentRouteName, string $route, Request $request)
    {
        $user = $request->user($guard);
        $configKey = $guard;

        if('customer' === $guard) {
            switch ($user->type) {
                case 'guest':
                case 'permanent':
                    $configKey = $guard.'.boat';
                    break;
                case 'renter':
                    $configKey = $guard.'.renter';
                    break;
            }
        }
        $isMobile = (new MobileDetect())->isMobile();
        $currentRoutes = [];
        $routes = collect(config('port.menu.'.$configKey.'.items.'.$currentRouteName));

        if(isset($routes['items']) && is_array($routes['items']) && count($routes['items']) > 0) {
            $currentRoutes['items'] = collect($routes['items'])->filter(fn($item) => (
                !$isMobile
                || ($isMobile && ! $item['hide_on_mobile'])
            ));
        }

        $request->session()->put('currentRoutes', $currentRoutes);
        $request->session()->put('currentRoute', $route);

        if(Route::getRoutes()->hasNamedRoute($route)) {
            return redirect()->route($route);
        } else {
            return redirect()->back();
        }
    }
}
