<?php

namespace App\Http\Requests\Helper;

trait Fix
{
    public function fixCarNumber($str)
    {
        return preg_replace("/^([a-z]+\-[a-z]+)([0-9]+)$/i", '$1 $2', trim($str));
    }
}
