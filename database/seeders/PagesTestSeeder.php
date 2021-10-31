<?php
namespace Database\Seeders;

use App\Models\Page;
use Database\Seeders\Ext\MainTestSeeder;

class PagesTestSeeder extends MainTestSeeder
{
    protected $count = 3;
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
