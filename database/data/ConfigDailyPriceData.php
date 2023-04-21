<?php
namespace Database\Data;

class ConfigDailyPriceData
{
    /**
    * @var array $data
    */
    public static $data =  [
		[ 'id' => '1', 'model' => 'App\Models\CaravanDates', 'saison_date_id' => '2', 'price_type_id' => '6', 'from_unit' => '', 'until_unit' => '', 'price' => '15.00'],
		[ 'id' => '2', 'model' => 'App\Models\CaravanDates', 'saison_date_id' => '1', 'price_type_id' => '6', 'from_unit' => '', 'until_unit' => '', 'price' => '12.00'],
		[ 'id' => '3', 'model' => 'App\Models\GuestBoatDates', 'saison_date_id' => '2', 'price_type_id' => '1', 'from_unit' => '', 'until_unit' => '', 'price' => '1.50'],
		[ 'id' => '4', 'model' => 'App\Models\GuestBoatDates', 'saison_date_id' => '1', 'price_type_id' => '1', 'from_unit' => '', 'until_unit' => '', 'price' => '1.50']
	];
}
