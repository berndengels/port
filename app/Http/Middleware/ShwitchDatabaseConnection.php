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
        $auth = auth('admin');
        if($user = $request->user('admin')) {
            if('test@test.com' === $user->email) {
                DB::purge('port');
                DB::setDefaultConnection('test');
                $testUser = AdminUser::whereEmail($user->email)->first();
                if(!$testUser->hasRole('admin')) {
                    $testUser->assignRole('admin');
                }
                $auth->setUser($testUser);
                unset($user);
            }
        }
        return $next($request);
    }
}
