<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $startRouteName = 'public.dashboard';

    public function main()
    {
        if(auth()->check()) {
            $this->startRouteName = 'admin.dashboard';
        }
        return redirect()->route($this->startRouteName);
    }
}
