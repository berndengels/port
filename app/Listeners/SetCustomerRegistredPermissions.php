<?php

namespace App\Listeners;

use Exception;
use App\Models\Role;
use App\Models\Customer;
use Illuminate\Auth\Events\Registered;

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
            $customer = $event->user;
            $role = null;
            switch ($customer->type) {
                case 'permanent':
                case 'boat':
                    $role = Role::whereName('boat')->whereGuardName('customer')->first();
                    break;
                case 'renter':
                    $role = Role::whereName('renter')->whereGuardName('customer')->first();
                    break;
            }
            if($role) {
                $customer
                    ->syncRoles([$role])
                    ->saveQuietly()
                ;
            }
        } catch(Exception $e) {
            throw $e;
        }
    }
}
