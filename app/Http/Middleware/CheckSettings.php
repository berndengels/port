<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\ConfigSetting;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class CheckSettings extends Middleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        /**
         * @var $response Response
         */
        $response = $next($request);
        $auth = Auth::guard('admin');
        if($auth->check()) {
            if($auth->user()->can('write ConfigSettings') && !ConfigSetting::first()) {
                return redirect()->route('admin.config.settings.create')->with('error', 'Bitte erst die Grunddaten anlegen!');
            }
        }
        return $response;
    }
}
