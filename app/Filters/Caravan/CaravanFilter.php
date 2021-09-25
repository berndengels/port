<?php

namespace App\Filters\Caravan;

use Closure;
use App\Filters\IPipe;
use Illuminate\Database\Eloquent\Builder;

class CaravanFilter implements IPipe
{
    public function apply(Builder $query, Closure $next)
    {
        if(request()->has('caravan')) {
            $query->whereId(request()->input('caravan'));
        }
        return $next($query);
    }
}
