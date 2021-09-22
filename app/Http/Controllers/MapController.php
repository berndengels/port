<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class MapController extends AdminController
{
    public function nautic()
    {
        return Inertia::render('Map/Nautic');
    }
}
