<?php

namespace App\Libs;

use Route;
use App\Models\Page;

/**
 * App\Libs\Routes
 */
class Routes
{
	/**
	 * @var array
	 */
	public static $routes = [];

	public static function getRoutes( $prefix = null )
	{
		$routes = collect(Route::getRoutes()->getRoutesByName());

        if( $prefix ) {
			$routes = $routes->reject(fn ($value, $key) => !preg_match("#$prefix#", $key));
		}

		foreach($routes as $r) {
			if( !preg_match("/\{[^\}]+\}/", $r->uri) ) {
				$uri = '/' . ltrim($r->uri, '/');
				self::$routes[$uri] = $uri;
			}
		}

		self::$routes = collect(self::$routes);
		return self::$routes;
	}

	public static function getPageRoutes()
	{
		return collect(PageRepository::getRoutes());
	}

	public static function getPublicRoutes()
	{
		return self::getPageRoutes()
            ->merge(self::getRoutes('public'))
//            ->merge(self::getRoutes('contact'))
            ;
	}
}
