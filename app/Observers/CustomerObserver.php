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
        $role = Role::whereName('boat')->whereGuardName('customer')->get();
        if(! $customer->hasRole($role)) {
            $customer->assignRole($role);
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
