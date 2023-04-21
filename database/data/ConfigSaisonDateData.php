<?php
namespace Database\Data;

class ConfigSaisonDateData
{
    /**
    * @var array $data
    */
    public static $data =  [
		[ 'id' => '1', 'name' => 'Nebensaison', 'key' => 'guest', 'mode' => '', 'from_day' => '1', 'from_month' => '10', 'until_day' => '31', 'until_month' => '5', 'from_mday' => '1001', 'until_mday' => '531'],
		[ 'id' => '2', 'name' => 'Hauptsaison', 'key' => 'guest', 'mode' => '', 'from_day' => '1', 'from_month' => '6', 'until_day' => '30', 'until_month' => '9', 'from_mday' => '601', 'until_mday' => '930'],
		[ 'id' => '3', 'name' => 'Winterlager Boote, Nebensaison', 'key' => 'customer', 'mode' => 'winter', 'from_day' => '1', 'from_month' => '10', 'until_day' => '31', 'until_month' => '5', 'from_mday' => '1001', 'until_mday' => '531'],
		[ 'id' => '4', 'name' => 'Sommer-Liegeplatz Boote, Hauptsaison', 'key' => 'customer', 'mode' => 'summer', 'from_day' => '1', 'from_month' => '6', 'until_day' => '30', 'until_month' => '9', 'from_mday' => '601', 'until_mday' => '930']
	];
}
