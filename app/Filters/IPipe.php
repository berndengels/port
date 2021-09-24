<?php
namespace App\Filters;

use Closure;
use Illuminate\Http\Request;

interface IPipe
{
    public function apply($content, Closure $next, Request $request);
}
