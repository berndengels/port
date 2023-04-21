<?php
namespace App\Providers;

use App\Http\Kernel;
use Carbon\Carbon;
use Laravel\Dusk\Browser;
use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider as BaseProvider;

class DuskServiceProvider extends BaseProvider
{
    public function boot()
    {
        parent::boot();
        Browser::macro(
            'typeDate', function ($selector, Carbon $date) {
                $this
                    ->keys($selector, $date->format('d'))
                    ->keys($selector, $date->format('m'))
                    ->keys($selector, $date->format('Y'));

                return $this;
            }
        );
        Browser::macro(
            'wait', function (int $seconds) {
                sleep($seconds);
                return $this;
            }
        );
        Browser::macro(
            'stepScreenshot', function ($directory) {
                if(! isset($this->counter)) {
                    $this->counter = 0;
                }
                $filePath = sprintf('%s/%s/%d.png', rtrim(static::$storeScreenshotsAt, '/'), $directory, $this->counter);
                $directoryPath = dirname($filePath);
                if (! is_dir($directoryPath)) {
                    mkdir($directoryPath, 0777, true);
                }
                $this->driver->takeScreenshot($filePath);
                ++$this->counter;
                return $this;
            }
        );
    }
}
