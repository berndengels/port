<?php

namespace App\Providers;

use Illuminate\View\FileViewFinder;
use Illuminate\View\ViewServiceProvider;
use Illuminate\Foundation\Application;

class ViewPlatformProvider extends ViewServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function registerViewFinder()
    {
        $this->app->bind('view.finder', function (Application $app) {
			$paths = [];
            if(config('app.platform')) {
                $paths[] = resource_path('platform/' . config('app.platform'). '/views');
	            $paths += $app['config']['view.paths'];
            }
	        $paths[] = $app->viewPath();

            return new FileViewFinder($app['files'], $paths);
        });
    }
}
