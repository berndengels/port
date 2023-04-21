<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UnAuthorizedAction
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        /**
         * @var Response $response
         */
        $response = $next($request);
        // action is unauthorized
        if($response instanceof Response && method_exists($response, 'status') && 403 === $response->status() ) {
            $user = $request->user();
            return redirect()->back()->with('error', "Sorry, diese Aktion ist für User: $user->name nicht erlaubt!");
        }
        return $response;
    }
}
