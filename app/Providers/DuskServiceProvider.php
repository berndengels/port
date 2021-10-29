<?php
namespace App\Providers;

use App\Http\Kernel;
use Carbon\Carbon;
use Laravel\Dusk\Browser;
use Illuminate\Support\ServiceProvider;

class DuskServiceProvider extends ServiceProvider
{
    public function boot(Kernel $kernel) {
        Browser::macro('typeDate', function ($selector, Carbon $date) {
            $this
                ->keys($selector, $date->format('d'))
                ->keys($selector, $date->format('m'))
                ->keys($selector, $date->format('Y'))
            ;

            return $this;
        });
    }
}
