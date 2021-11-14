<?php

namespace Database\Seeders;

use App\Models\Material;
use App\Models\Service;
use Database\Data\ServiceData;
use Database\Seeders\Ext\MainTestSeeder;

class ServiceTestSeeder extends MainTestSeeder
{
    protected $table = 'services';
    protected $model = Service::class;
    protected $dataClass = ServiceData::class;

    /**
     * Run the database seeds.
     *
     * @return void
     */
/*
    public function run()
    {
        parent::run();
        $materials = Material::all();
        Service::each(fn(Service $s) => $s->materials()->sync($materials));
    }
*/
}
