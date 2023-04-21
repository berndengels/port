<?php
namespace Database\Data;

class ConfigPriceTypeData
{
    /**
    * @var array $data
    */
    public static $data =  [
		[ 'id' => '6', 'name' => 'Absolut', 'type' => 'absolute', 'unit' => ''],
		[ 'id' => '5', 'name' => 'pro  Quatratmeter', 'type' => 'area', 'unit' => 'm²'],
		[ 'id' => '3', 'name' => 'pro Kilogramm', 'type' => 'kilogram', 'unit' => 'Kg'],
		[ 'id' => '9', 'name' => 'pro Kilowatt', 'type' => 'kilowatt', 'unit' => 'KW'],
		[ 'id' => '2', 'name' => 'pro Liter', 'type' => 'volume', 'unit' => 'L'],
		[ 'id' => '1', 'name' => 'pro Meter', 'type' => 'length', 'unit' => 'm'],
		[ 'id' => '4', 'name' => 'pro Stunde', 'type' => 'hour', 'unit' => 'H'],
		[ 'id' => '7', 'name' => 'pro Tag', 'type' => 'day', 'unit' => 'T'],
		[ 'id' => '8', 'name' => 'pro Tonne', 'type' => 'ton', 'unit' => 't']
	];
}
