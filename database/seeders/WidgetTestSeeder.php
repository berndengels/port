<?php
namespace Database\Seeders;

use App\Models\Widget;
use Database\Seeders\Ext\MainTestSeeder;

class WidgetTestSeeder extends MainTestSeeder
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
            ->connection('test')
            ->count($this->count)
            ->create()
        ;
    }
}
