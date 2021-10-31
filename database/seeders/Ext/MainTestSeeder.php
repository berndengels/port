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
    protected $count = 10;
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
        $this->dbProd = DB::connection('port');
        $this->dbTest = DB::connection('test');
        DB::setDefaultConnection('test');
    }

    public function run() {
        Eloquent::unguard();
        DB::setDefaultConnection('test');
        $this->dbTest->statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::disableForeignKeyConstraints();
//        $this->dbTest->table($this->table)->delete();
//        $this->dbTest->table($this->table)->truncate();

        if($this->dataClass && class_exists($this->dataClass)) {
            $this->inserByData($this->dataClass);
        } {
            $this->insertByTable();
        }

        if($this->model) {
            ($this->model)::getModel()->refresh();
        }
        Schema::enableForeignKeyConstraints();
        $this->dbTest->statement('SET FOREIGN_KEY_CHECKS=1;');
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
