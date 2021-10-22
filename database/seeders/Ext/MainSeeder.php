<?php
namespace Database\Seeders\Ext;

use PDO;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Connection;

class MainSeeder extends Seeder
{
    protected $count = 100;
    /**
     * @var Connection
     */
    protected $dbProd;
    /**
     * @var Connection
     */
    protected $dbTest;
    protected $table;

    public function __construct()
    {
        $this->dbProd = DB::connection('mysql');
        $this->dbTest = DB::connection('mysql-test');
        Schema::disableForeignKeyConstraints();
        $this->dbTest->table($this->table)->delete();
    }

    public function run() {
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
