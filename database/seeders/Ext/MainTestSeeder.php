<?php
namespace Database\Seeders\Ext;

use App\Models\Role;
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
    protected $dbProd;
    /**
     * @var Connection
     */
    protected $dbTest;
    protected $table;
    protected $model;
    protected $dataClass;
    protected $useFactory = false;

    public function __construct()
    {
        $this->dbProd = DB::connection('mysql');
        $this->dbTest = DB::connection('demo');
        DB::setDefaultConnection('demo');
        $this->dbTest->statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::disableForeignKeyConstraints();
    }

    public function run() {
        Eloquent::unguard();
//        $this->dbTest->statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::disableForeignKeyConstraints();

        if($this->dataClass && class_exists($this->dataClass)) {
            $this->inserByData($this->dataClass);
        } {
//            $this->insertByTable();
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
                    $this->dbTest->table($this->table)->insertOrIgnore($row);
                }
            }
        }
    }

    protected function insertByTable() {
        $items = $this->dbProd
            ->getPdo()
            ->query("SELECT * FROM $this->table")
            ->fetchAll(PDO::FETCH_ASSOC)
        ;
        if($items && count($items) > 0) {
            foreach ($items as $item) {
                $this->dbTest->table($this->table)->insertOrIgnore($item);
            }
        }
    }
}
