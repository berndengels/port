<?php
namespace Database\Data;

class HouseboatModelData
{
    /**
    * @var array $data
    */
    public static $data =  [
		[ 'id' => 1, 'name' => 'Grande', 'description' => 'Das ist unser größtes Hausboot.', 'space' => 120, 'floors' => 2, 'sleeping_places' => 8, 'peak_season_price' => '220', 'mid_season_price' => '180', 'low_season_price' => 140],
		[ 'id' => 2, 'name' => 'Medium', 'description' => 'Das ist unser mittelgroßes Hausboot.', 'space' => 80, 'floors' => 2, 'sleeping_places' => 6, 'peak_season_price' => '180', 'mid_season_price' => '160', 'low_season_price' => 130],
		[ 'id' => 3, 'name' => 'Petite', 'description' => 'Das ist unser kleinstes Hausboot.', 'space' => 60, 'floors' => 1, 'sleeping_places' => 4, 'peak_season_price' => '150', 'mid_season_price' => '130', 'low_season_price' => 110]
	];
}
