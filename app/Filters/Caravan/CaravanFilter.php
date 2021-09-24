<?php

namespace App\Filters\Caravan;

use Closure;
use App\Filters\IPipe;
use Illuminate\Http\Request;

class CaravanFilter implements IPipe
{
    public function apply($caravans, Closure $next, Request $request)
    {
        if($request->has('caravan')) {
            $caravans->find($request->input('carnumber'));
        }
        return $next($caravans);
    }
}
