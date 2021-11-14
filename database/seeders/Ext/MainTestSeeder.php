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
    protected $count = 5;
    /**
     * @var Connection
     */
    protected $table;
    /**
     * @var Model $model
     */
    protected $model;
    protected $dataClass;
    protected $useFactory = false;

    public function __construct()
    {
//        $this->dbTest = DB::connection('demo');
//        DB::setDefaultConnection('demo');
//        DB::connection()->statement('SET FOREIGN_KEY_CHECKS=0;');
        if('testing' === DB::connection()->getDriverName()) {
        }
        Schema::disableForeignKeyConstraints();
    }

    public function run() {
        Eloquent::unguard();
//        $this->dbTest->statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::disableForeignKeyConstraints();

        if($this->dataClass && class_exists($this->dataClass)) {
            $this->inserByData($this->dataClass);
        }

        if($this->model) {
            ($this->model)::getModel()->refresh();
        }
        Schema::enableForeignKeyConstraints();
//        $this->dbTest->statement('SET FOREIGN_KEY_CHECKS=1;');
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
