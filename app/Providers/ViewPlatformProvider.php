<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\View\FileViewFinder;
use Illuminate\View\ViewServiceProvider;
class ViewPlatformProvider extends ViewServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function registerViewFinder()
    {
        $this->app->bind('view.finder', function ($app) {
            $paths = [];
            if(config('app.platform')) {
                $paths[] = resource_path('platform/' . config('app.platform'). '/views');
            }
            $paths += $app['config']['view.paths'];

            return new FileViewFinder($app['files'], $paths);
        });
    }
}
