<?php

namespace App\Http\Controllers;

//use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class GuardedController extends Controller
{
    use AuthorizesRequests;

    public function authorizeForUser($user, $ability, $arguments = [])
    {
        $user = auth('customer')->user();
        return parent::authorizeForUser($user, $ability, $arguments);
    }
}
