<?php
namespace App\Providers;

use Debugbar;
use App\Http\Kernel;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Http\Middleware\HandleInertiaRequests;
use Mnabialek\LaravelQuickMigrations\Providers\ServiceProvider as QuickMigrationsServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Kernel $kernel)
    {
        Schema::defaultStringLength(191);
        env('APP_DEBUG_BAR') ? Debugbar::enable() : Debugbar::disable();
        Paginator::useTailwind();
    }
}
