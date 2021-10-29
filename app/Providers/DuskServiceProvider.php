<?php
namespace App\Providers;

use App\Http\Kernel;
use Carbon\Carbon;
use Laravel\Dusk\Browser;
use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider as BaseProvider;

class DuskServiceProvider extends BaseProvider
{
    public function boot() {
        parent::boot();
        Browser::macro('typeDate', function ($selector, Carbon $date) {
            $this
                ->keys($selector, $date->format('d'))
                ->keys($selector, $date->format('m'))
                ->keys($selector, $date->format('Y'))
            ;

            return $this;
        });
        Browser::macro('wait', function (int $seconds) {
            sleep($seconds);
            return $this;
        });
    }
}
