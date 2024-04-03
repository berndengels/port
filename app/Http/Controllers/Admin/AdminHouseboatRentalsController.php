<?php

namespace App\Http\Controllers\Admin;

use App\Models\Houseboat;

class AdminHouseboatRentalsController extends AdminRentalsController
{
    protected $relationModel = Houseboat::class;
    protected string $relationName = 'houseboat';
    protected string $routeName = 'houseboatRentals';
	protected string $customerType = 'houseboat';
}
