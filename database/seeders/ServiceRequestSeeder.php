<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Boat;
use App\Models\Service;
use App\Models\ServiceRequest;
use Database\Seeders\Ext\MainTestSeeder;

class ServiceRequestSeeder extends MainTestSeeder
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
        $date = Carbon::today()->addMonths(rand(1,10))->format('Y-m-d');
        $params = [
            'boat_id'       => $boat->id,
            'description'   => 'Test Service Anfrage für '.$date,
            'done_until'    => $date,
        ];
        ServiceRequest::create($params)
            ->services()
            ->sync($services)
        ;
    }
}
