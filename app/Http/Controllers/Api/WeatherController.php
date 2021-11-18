<?php

namespace App\Http\Controllers\Api;

use GuzzleHttp\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class WeatherController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  Request  $request
     * @return Response
     */
    public function __invoke()
    {
        return Cache::remember('weather', 3600, function() {
            $lat = config('port.map.lat');
            $lng = config('port.map.lng');
            $apiKey = env('MIX_WEATHER_API_KEY');
            $apiUrl = str_replace(['%LAT%','%LNG%'], [$lat, $lng],env('MIX_WEATHER_API_URL').$apiKey);

            $client = new Client();
            $request =  $client->get($apiUrl);
            $response = $request->getBody()->getContents();

            return $response;
        });
    }
}
