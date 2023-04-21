<?php
namespace Database\Seeders;

use App\Models\Widget;
use Database\Seeders\Ext\MainTestSeeder;

class WidgetSeeder extends MainTestSeeder
{
    protected $count = 3;
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
