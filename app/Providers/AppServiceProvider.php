<?php
namespace App\Providers;

//use Illuminate\Foundation\Http\Kernel;
use App\Http\Kernel;
use Debugbar;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
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
        env('APP_DEBUG_BAR') ? Debugbar::enable() : Debugbar::disable();
        Paginator::useTailwind();
        View::share('routePrefix', auth()->check() ? 'admin' : 'public');
    }
}
