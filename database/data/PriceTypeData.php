<?php
namespace Database\Data;

class PriceTypeData
{
    /**
    * @var array $data
    */
    public static $data =  [
		[ 'id' => '5', 'name' => 'pro  Quatratmeter', 'type' => 'area', 'unit' => 'm²'],
		[ 'id' => '3', 'name' => 'pro Kilogramm', 'type' => 'weight', 'unit' => 'Kg'],
		[ 'id' => '2', 'name' => 'pro Liter', 'type' => 'volume', 'unit' => 'L'],
		[ 'id' => '1', 'name' => 'pro Meter', 'type' => 'length', 'unit' => 'm'],
		[ 'id' => '4', 'name' => 'pro Stunde', 'type' => 'time', 'unit' => 'H']
	];
}
