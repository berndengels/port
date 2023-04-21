<?php

namespace App\Observers;

use App\Models\Boat;
use App\Models\Customer;
use App\Models\Role;
use Illuminate\Auth\Events\Registered;

class CustomerObserver
{
    /**
     * Handle the Customer "created" event.
     *
     * @param Customer $customer
     * @return void
     */
    public function created(Customer $customer)
    {
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

        if($role && !$customer->hasRole($role)) {
            $customer->assignRole($role)->saveQuietly();
        }
    }

    /**
     * Handle the Customer "updated" event.
     *
     * @param Customer $customer
     * @return void
     */
    public function updated(Customer $customer)
    {
        if($customer->confirmed) {
            // @todo: set event for customer notification
        }
    }
}
