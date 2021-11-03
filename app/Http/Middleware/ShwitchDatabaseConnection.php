<?php

namespace App\Http\Middleware;

use App\Models\AdminUser;
use App\Models\Permission;
use App\Models\Role;
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
        if($auth->check()) {
            $user = $request->user('admin');
            if('demo@test.com' === $user->email || app()->environment(['demo','dusk.local'])) {
                DB::purge('mysql');
                DB::setDefaultConnection('demo');
                app('cache')->clear();
                config()->set('app.env', 'dusk.local');

                $role = Role::whereName('admin')->whereGuardName('admin')->first();
                if(!$role) {
                    $role = Role::create(['name'=>'admin','guard_name'=>'admin']);
                }

                $role->syncPermissions(Permission::whereGuardName('admin')->get());
                $testUser = AdminUser::whereEmail($user->email)->first();
                $testUser->syncRoles($role)->refresh();

                $auth->setUser($testUser);
                unset($user);
            }
        }
        return $next($request);
    }
}
