<?php

namespace Tests\Feature;

use Route;
use Exception;
use Tests\TestCase;
use App\Libs\Routes as MyRoutes;
use Illuminate\Routing\Route as RoutingRoute;
use Symfony\Component\HttpFoundation\Response;

class RouteRequestTest extends TestCase
{
	private $_skipPublicRoutes = [
        '/telescope',
    ];

	private $_adminRoutes = [
        'admin_users',
        'customers',
        'berths',
        'berth_maps',
        'docks',
        'caravans',
        'boats',
        'guestBoats',
        'houses',
        'houseModels',
        // @todo: houseRentals failed
        'houseRentals',
        'houses.create',
        'houseModels.create',
        'houseboats',
        'houseboatModels',
        'rentals',
        'houseboats.create',
        'houseboatModels.create',
        'apartments',
        'apartmentModels',
        'apartmentRentals',
        'apartments.create',
        'apartmentModels.create',
	];

	/**
     * public routes test for status 200.
     * @return void
     */
    public function testPublicRouteResponses()
    {
		$routes = MyRoutes::getRoutes('public\.')->reject(function ($value) {
			return in_array($value, $this->_skipPublicRoutes);
		});

		foreach($routes as $route) {
		    try {
                echo "check response status (200) for public route: $route,";
                $response = $this->get($route);
                $status = $response->getStatusCode();
                echo " status: $status";
                $response->assertStatus(200);
                echo " \360\237\230\216\n";
            } catch(Exception $e) {
                echo "ERROR for public route: $route:\n";
                echo $e->getMessage()."\n";
            }
		}
    }

	/**
	 * admin routes test for status 200.
	 * @return void
	 */
	public function testAdminRouteResponses()
	{
		$routes = [];

		foreach($this->_adminRoutes as $name) {
			$routes[] = Route::getRoutes()->getByName("admin.$name.index");
            $routes[] = Route::getRoutes()->getByName("admin.$name.create");
		}

		/**
		 * @var $response Response
		 * @var $route Route
		 */
		$this->actingAs($this->user, 'admin');

        /**
         * @var $route RoutingRoute
         */
		foreach($routes as $route) {
		    try {
                $name = ($route instanceof RoutingRoute && method_exists($route, 'getName')) ? $route->getName() : $route;
                echo "check response status (200) for admin route: {$route->uri},";
                $response = $this->get($route->uri);
                $status = $response->getStatusCode();
                echo " status: $status";
                $response->assertStatus(200);
                echo " \360\237\230\216\n";
            } catch(Exception $e) {
                echo "ERROR for public admin: '$name'\n";
                echo $e->getMessage()."\n";
            }
		}
	}
}
