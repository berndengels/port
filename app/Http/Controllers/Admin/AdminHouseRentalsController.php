<?php

namespace App\Http\Controllers\Admin;

use App\Models\House;

class AdminHouseRentalsController extends AdminRentalsController
{
    protected $relationModel = House::class;
    protected string $relationName = 'house';
    protected string $routeName = 'houseRentals';
	protected string $customerType = 'house';
}
