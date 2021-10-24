<?php
namespace Database\Seeders;

use App\Models\Widget;
use Database\Seeders\Ext\MainSeeder;

class WidgetSeeder extends MainSeeder
{
    protected $count = 10;
    protected $table = 'widgets';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Widget::factory()
            ->count($this->count)
            ->create()
        ;
    }
}
