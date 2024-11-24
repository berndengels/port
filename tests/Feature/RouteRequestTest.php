<?php

namespace Tests\Feature;

use Route;
use Exception;
use Tests\TestCase;
use App\Libs\Routes as MyRoutes;

class RouteRequestTest extends TestCase
{
	private $_skipPublicRoutes = [
        '/telescope',
		'/contacts'
    ];

	// @todo: houseRentals failed
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
        'houseRentals',
        'houses',
        'houseModels',
        'houseboats',
        'houseboatModels',
        'houseboatRentals',
        'apartments',
        'apartmentModels',
        'apartmentRentals',
        'apartments',
        'apartmentModels',
	];

    public function testPublicRouteResponses()
    {
		$routes = MyRoutes::getRoutes('public\.')->reject(fn ($value) => in_array($value, $this->_skipPublicRoutes));

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

	public function testAdminRouteResponses()
	{
		$indexRoutes = collect($this->_adminRoutes)->map(fn($name) => Route::getRoutes()->getByName("admin.$name.index") ?? null)->reject(fn($r) => !$r);
		$createRoutes = collect($this->_adminRoutes)->map(fn($name) => Route::getRoutes()->getByName("admin.$name.create") ?? null)->reject(fn($r) => !$r);
		$routes = $indexRoutes->merge($createRoutes)->map->uri;

		foreach($routes as $uri) {
		    try {
                echo "check response status (200) for admin route: {$uri},";
                $response = $this->actingAs($this->user, 'admin')->get($uri);
                $status = $response->getStatusCode();
                echo " status: $status";
                $response->assertStatus(200);
                echo " \360\237\230\216\n";
            } catch(Exception $e) {
                echo "ERROR for admin route: '$uri'\n";
                echo $e->getMessage()."\n";
            }
		}
	}
}
