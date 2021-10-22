<?php
namespace App\Repositories;

use App\Models\Caravan;
use App\Repositories\Ext\SelectOptions;

class CaravanRepository extends Repository
{
    use SelectOptions;

    protected static $model = Caravan::class;

}
