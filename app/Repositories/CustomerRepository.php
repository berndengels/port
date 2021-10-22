<?php
namespace App\Repositories;

use App\Models\Customer;
use App\Repositories\Ext\SelectOptions;

class CustomerRepository extends Repository
{
    use SelectOptions;

    protected static $model = Customer::class;
}
