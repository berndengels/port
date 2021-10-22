<?php

namespace App\Http\Middleware;

use App\Models\AdminUser;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShwitchDatabaseConnection
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
         * @var $user AdminUser
         */
        if($user = $request->user('admin')) {
            if('test@test.com' === $user->email) {
                DB::purge('mysql');
                DB::setDefaultConnection('mysql-test');
                $user = AdminUser::whereEmail($user->email)->first();
                if(!$user->hasRole('demonstration')) {
                    $user->assignRole('demonstration');
                }
            }
        }
        return $next($request);
    }
}
