<?php
namespace App\Repositories;

use App\Libs\AppCache;
use App\Models\Customer;
use App\Repositories\Ext\SelectOptions;

class CustomerRepository extends Repository
{
    use SelectOptions;

    protected static $model = Customer::class;
    protected static $cacheKeyOptions = AppCache::KEY_OPTIONS_CUSTOMER;
    protected static $cacheKeyOptionsData = AppCache::KEY_OPTIONS_DATA_CUSTOMER;
}
