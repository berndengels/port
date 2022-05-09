<?php
namespace App\Providers;

use App\Models\ConfigOffer;
use Debugbar;
use App\Http\Kernel;
use Exception;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
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
        Blade::if('adminOrCustomer', function () {
            return auth('admin')->check() || auth('customer')->check();
        });

        try {
            $offers = ConfigOffer::all();
            $menuConfig = config('port.menu.admin.items');
            foreach ($offers as $offer) {
                if(isset($menuConfig[$offer->name]) && !$offer->enabled) {
                    Config::set('port.menu.admin.items.'.$offer->name, null);
                }
            }
        } catch (Exception $e) {}
    }
}
