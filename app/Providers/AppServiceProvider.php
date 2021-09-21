<?php

namespace App\Providers;

//use Illuminate\Foundation\Http\Kernel;
use App\Http\Kernel;
use Illuminate\Support\ServiceProvider;
use App\Http\Middleware\HandleInertiaRequests;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Kernel $kernel)
    {
        if(env('MIX_APP_MODE') === 'inertia') {
//            $kernel->prependMiddlewareToGroup('web', HandleInertiaRequests::class);
            $kernel->appendMiddlewareToGroup('web', HandleInertiaRequests::class);
        }
    }
}
