<?php

namespace App\Libs\Prices\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasModel
{
    protected function useModel(array &$args, Model $model )
    {
        $args[] = $model;
    }
}