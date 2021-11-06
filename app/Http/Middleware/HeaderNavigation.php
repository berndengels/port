<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class HeaderNavigation
{
    /**
     * Handle an incoming request.
     *
     * @param  Request $request
     * @param  Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->session()->has('currentRoutes')) {
            $currentRouteName = Route::current()->getName();
            $topRoutes = isset($request->session()->get('currentRoutes')['items']) ? collect($request->session()->get('currentRoutes')['items'])->map->route : null;
            if($topRoutes && $topRoutes->contains($currentRouteName) ) {
                $request->session()->put('currentTopRouteName', $currentRouteName);
            }
        }
        return $next($request);
    }
}
