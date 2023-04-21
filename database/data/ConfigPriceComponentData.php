<?php
namespace Database\Data;

class ConfigPriceComponentData
{
    /**
    * @var array $data
    */
    public static $data =  [
		[ 'id' => '1', 'price_type_id' => '7', 'config_service_id' => '1', 'name' => 'Stromanschluß pro Tag (Gäste)', 'key' => 'electric', 'unit_inclusive' => '', 'unit_price' => '2.00'],
		[ 'id' => '2', 'price_type_id' => '7', 'config_service_id' => '', 'name' => 'Personen pro Tag (Gäste)', 'key' => 'persons', 'unit_inclusive' => '2', 'unit_price' => '1.00'],
		[ 'id' => '3', 'price_type_id' => '8', 'config_service_id' => '4', 'name' => 'Boot Kranen', 'key' => 'crane', 'unit_inclusive' => '', 'unit_price' => '20.00'],
		[ 'id' => '4', 'price_type_id' => '6', 'config_service_id' => '5', 'name' => 'Mast Kranen', 'key' => 'mast_crane', 'unit_inclusive' => '', 'unit_price' => '40.00'],
		[ 'id' => '5', 'price_type_id' => '1', 'config_service_id' => '6', 'name' => 'Unterschiff Reinigung', 'key' => 'cleaning', 'unit_inclusive' => '', 'unit_price' => '3.00'],
		[ 'id' => '6', 'price_type_id' => '9', 'config_service_id' => '1', 'name' => 'Strom pro Kilowatt', 'key' => 'kilowatt', 'unit_inclusive' => '', 'unit_price' => '1.00'],
		[ 'id' => '7', 'price_type_id' => '8', 'config_service_id' => '7', 'name' => 'Boots-Transport im Hafen', 'key' => 'transport', 'unit_inclusive' => '', 'unit_price' => '20.00'],
		[ 'id' => '8', 'price_type_id' => '5', 'config_service_id' => '8', 'name' => 'Reinigung Mietobjekt', 'key' => 'rental_cleaning', 'unit_inclusive' => '', 'unit_price' => '0.50']
	];
}
