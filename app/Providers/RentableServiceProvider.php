<?php

namespace App\Providers;

use App\Models\Apartment;
use App\Models\House;
use App\Models\Houseboat;
use Spatie\Permission\Models\Permission;
use App\Models\Role;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class RentableServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register() {}

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'apartment' => Apartment::class,
            'house'     => House::class,
            'houseboat' => Houseboat::class,
        ]);
    }
}
