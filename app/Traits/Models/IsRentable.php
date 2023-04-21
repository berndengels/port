<?php

namespace App\Traits\Models;

trait IsRentable
{
    protected $isRentable = true;
    protected $rentableType;

    public function isRentable()
    {
        return true;
    }
}
