<?php
namespace Database\Data;

class ConfigOfferData
{
    /**
    * @var array $data
    */
    public static $data =  [
		[ 'id' => '1', 'name' => 'Caravans', 'model' => 'App\Models\Caravan', 'enabled' => '1'],
		[ 'id' => '2', 'name' => 'Boote', 'model' => 'App\Models\Boat', 'enabled' => '1'],
		[ 'id' => '3', 'name' => 'Hausboote', 'model' => 'App\Models\Houseboat', 'enabled' => '1'],
		[ 'id' => '4', 'name' => 'Services', 'model' => 'App\Models\Service', 'enabled' => '1'],
		[ 'id' => '6', 'name' => 'Häuser', 'model' => 'App\Models\House', 'enabled' => '1'],
		[ 'id' => '7', 'name' => 'Apartments', 'model' => 'App\Models\Apartment', 'enabled' => '1']
	];
}
