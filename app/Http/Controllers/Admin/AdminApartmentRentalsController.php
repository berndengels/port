<?php

namespace App\Http\Controllers\Admin;

use App\Models\Apartment;

class AdminApartmentRentalsController extends AdminRentalsController
{
    protected $relationModel = Apartment::class;
    protected string $relationName = 'apartment';
    protected string $routeName = 'apartmentRentals';
}
