<?php

namespace Database\Seeders;

use App\Models\Boat;
use App\Models\Service;
use App\Models\ServiceRequest;
use Database\Seeders\Ext\MainTestSeeder;

class ServiceRequestTestSeeder extends MainTestSeeder
{
    protected $table = 'service_requests';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $boats = Boat::all();
        $services = Service::all();

        $boat = $boats[rand(0, $boats->count() - 1)];
        $service = $services[rand(0, $services->count() - 1)];

        ServiceRequest::factory()
            ->hasServices($service)
            ->create()
            ->boat()
            ->associate($boat)
            ->save()
        ;
    }
}
