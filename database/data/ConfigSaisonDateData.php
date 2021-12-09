<?php
namespace Database\Data;

class ConfigSaisonDateData
{
    /**
    * @var array $data
    */
    public static $data =  [
		[ 'id' => '1', 'name' => 'Nebensaison', 'key' => 'guest', 'mode' => null, 'from_day' => '01', 'from_month' => '10', 'until_day' => '31', 'until_month' => '05', 'from_mday' => '1001', 'until_mday' => '531'],
		[ 'id' => '2', 'name' => 'Hauptsaison', 'key' => 'guest', 'mode' => null, 'from_day' => '01', 'from_month' => '06', 'until_day' => '30', 'until_month' => '09', 'from_mday' => '601', 'until_mday' => '930'],
		[ 'id' => '3', 'name' => 'Winterlager Boote', 'key' => 'customer', 'mode' => 'winter', 'from_day' => '01', 'from_month' => '10', 'until_day' => '31', 'until_month' => '05', 'from_mday' => '1001', 'until_mday' => '531'],
		[ 'id' => '4', 'name' => 'Sommer-Liegeplatz Boote', 'key' => 'customer', 'mode' => 'summer', 'from_day' => '01', 'from_month' => '06', 'until_day' => '30', 'until_month' => '09', 'from_mday' => '601', 'until_mday' => '930']
	];
}
