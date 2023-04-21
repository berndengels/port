<?php

namespace App\Http\Middleware;

use App\Events\OnStart;
use App\Models\ConfigSetting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  Request     $request
     * @param  Closure     $next
     * @param  string|null ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        switch ($guard) {
            case 'admin':
                if(Auth::guard($guard)->check()) {
                    return redirect(RouteServiceProvider::ADMIN_HOME);
                }
                break;
            case 'customer':
            default:
                if(Auth::guard($guard)->check()) {
                    return redirect(RouteServiceProvider::HOME);
                }
                break;
        }
        return $next($request);
    }
}
