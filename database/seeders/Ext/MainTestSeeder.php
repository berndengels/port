<?php

namespace Database\Seeders\Ext;

use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use PDO;
use Eloquent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Connection;

class MainTestSeeder extends Seeder
{
    protected $count = 50;
    /**
     * @var Connection
     */
    protected $table;
    /**
     * @var Model $model
     */
    protected $model;
    protected $dataClass;

    public function run() {
        Eloquent::unguard();
        Schema::disableForeignKeyConstraints();

        if($this->dataClass && class_exists($this->dataClass)) {
            $this->inserByData($this->dataClass);
        }

        if($this->model) {
            ($this->model)::getModel()->refresh();
        }
        Schema::enableForeignKeyConstraints();
    }

    protected function inserByData($dataClass) {
        if(property_exists($dataClass, 'data')) {
            if ($this->table && count($dataClass::$data) > 0) {
                foreach($dataClass::$data as $row) {
                    DB::connection(config('database.default'))->table($this->table)->insertOrIgnore($row);
                }
            }
        }
    }
}
