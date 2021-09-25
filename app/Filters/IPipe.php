<?php
namespace App\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

interface IPipe
{
    public function apply(Builder $query, Closure $next);
}
