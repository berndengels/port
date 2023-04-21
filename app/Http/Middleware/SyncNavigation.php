<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class SyncNavigation
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
        $currentRoute = Route::current()->getName();
        if($request->session()->has('currentRoutes')) {
            $topRoutes = isset($request->session()->get('currentRoutes')['items']) ? collect($request->session()->get('currentRoutes')['items'])->map->route : null;
            if($topRoutes && $topRoutes->contains($currentRoute) ) {
                $request->session()->put('currentTopRoute', $currentRoute);
            }
        }
        return $next($request);
    }
}
