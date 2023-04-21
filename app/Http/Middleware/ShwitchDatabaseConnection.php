<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Role;
use App\Models\AdminUser;
use App\Models\Customer;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ShwitchDatabaseConnection
{
    /**
     * Handle an incoming request.
     *
     * @param  Request $request
     * @param  Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(app()->environment(['testing'])) {
            return $next($request);
        }

        $authAdmin = auth('admin');
        $authCustomer = auth('customer');

        if($authAdmin->check() || $authCustomer->check()) {
            /**
             * @var $user Customer|AdminUser
             */
            $user = null;
            $testUser = null;
            $guard = null;

            if($authAdmin->check()) {
                $user = $request->user('admin');
                $guard = 'admin';

            } elseif ($authCustomer->check()) {
                $user = $request->user('customer');
                $guard = 'customer';
            }

            if($user) {
                list(,$domain) = explode('@', $user->email);

                if($domain === 'test.loc' || app()->environment(['demo','dusk.local'])) {
                    DB::purge('mysql');
                    DB::setDefaultConnection('demo');
                    app('cache')->clear();
//                _config()->set('app.env', 'dusk.local');
                    config()->set('app.env', 'demo');

                    switch($guard) {
                        case 'admin':
                            $role = Role::whereName('admin')->whereGuardName('admin')->first();
                            if(!$role) {
                                $role = Role::create(['name' => 'admin', 'guard_name' => 'admin']);
                            }
                            $role->syncPermissions(Permission::whereGuardName('admin')->get());
                            $testUser = AdminUser::whereEmail($user->email)->first();
                            break;

                        case 'customer':
                            $role = Role::whereName('boat')->whereGuardName('customer')->first();
                            if(!$role) {
                                $role = Role::create(['name' => 'boat', 'guard_name' => 'customer']);
                            }
                            $role->syncPermissions(Permission::whereGuardName('customer')->get());
                            $testUser = Customer::whereEmail($user->email)->first();
                            break;
                    }
                }

                if($testUser && $role && $guard) {
                    $testUser->syncRoles($role)->refresh();
                    auth($guard)->setUser($testUser);
                    unset($user);
                }
            }
        }

        return $next($request);
    }
}
