<?php
namespace Database\Seeders;

use App\Models\Page;
use Database\Seeders\Ext\MainSeeder;

class PagesSeeder extends MainSeeder
{
    protected $count = 10;
    protected $table = 'pages';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Page::factory()
            ->count($this->count)
            ->create()
        ;
    }
}
