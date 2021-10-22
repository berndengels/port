<?php
namespace App\Repositories;

use App\Models\Country;
use App\Repositories\Ext\SelectOptions;

class CountryRepository extends Repository
{
    use SelectOptions;

    protected static $model = Country::class;

}
