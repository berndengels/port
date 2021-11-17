<?php
namespace Database\Data;

class MaterialCategoryData
{
    /**
    * @var array $data
    */
    public static $data =  [
		[ 'id' => '1', 'name' => 'Unterwasser Anstrich', 'modus' => 'underwater'],
		[ 'id' => '2', 'name' => 'Unterwasser Reinigung', 'modus' => 'underwater'],
		[ 'id' => '3', 'name' => 'Unterwasserschiff Schleifen', 'modus' => 'underwater'],
		[ 'id' => '4', 'name' => 'Motor', 'modus' => 'all'],
		[ 'id' => '5', 'name' => 'Elektrik', 'modus' => 'all'],
		[ 'id' => '6', 'name' => 'Wachs', 'modus' => 'board'],
		[ 'id' => '7', 'name' => 'Überwasser Anstrich', 'modus' => 'board'],
		[ 'id' => '8', 'name' => 'Überwasser Reinigung', 'modus' => 'board']
	];
}
