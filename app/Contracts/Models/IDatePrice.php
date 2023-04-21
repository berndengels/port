<?php

namespace App\Contracts\Models;

use Illuminate\Http\Client\Request;

interface IDatePrice
{
    public function getPrice(Request $request): float|int;
}
