<?php
namespace Database\Data;

class ModelHasRoleData
{
    /**
    * @var array $data
    */
    public static $data =  [
		[ 'role_id' => '1', 'model_type' => 'App\Models\Customer', 'model_id' => '1'],
		[ 'role_id' => '1', 'model_type' => 'App\Models\Customer', 'model_id' => '2'],
		[ 'role_id' => '2', 'model_type' => 'App\Models\AdminUser', 'model_id' => '2'],
		[ 'role_id' => '3', 'model_type' => 'App\Models\AdminUser', 'model_id' => '1'],
		[ 'role_id' => '5', 'model_type' => 'App\Models\AdminUser', 'model_id' => '3'],
		[ 'role_id' => '5', 'model_type' => 'App\Models\AdminUser', 'model_id' => '4']
	];
}
