<?php

namespace App\Listeners;

use App\Models\Customer;
use App\Models\Permission;
use App\Models\Role;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SetCustomerRegistredPermissions
{
    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        try {
            /**
             * @var $customer Customer
             */
            $customer    = $event->user;
            $roles       = Role::whereGuardName('customer')->whereName('boat')->first();
            $customer
                ->syncRoles($roles)
                ->saveQuietly()
            ;
        } catch(Exception $e) {
            throw $e;
        }
    }
}
