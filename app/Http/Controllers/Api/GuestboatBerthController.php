<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreGuestBoatBerthRequest;
use App\Http\Requests\UpdateGuestBoatBerthRequest;
use App\Http\Resources\GuestBoatBerthGeoJsonResource;
use App\Models\BoatDock;
use App\Models\GuestBoatBerth;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\GuestBoatBerthResource;

/**
 *
 */
class GuestboatBerthController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index()
    {
        $data = GuestBoatBerth::all()->sortBy('number', SORT_NATURAL);
        $data = GuestBoatBerthGeoJsonResource::collection($data);
        return response()->json($data);
    }

    /**
     * @return JsonResponse
     */
    public function docks()
    {
        $data = BoatDock::all()->sortBy('name', SORT_NATURAL);
        return response()->json($data);
    }

    /**
     * @param GuestBoatBerth $guestBoatBerth
     * @return JsonResponse
     */
    public function show(GuestBoatBerth $guestBoatBerth)
    {
        $data = new GuestBoatBerthGeoJsonResource($guestBoatBerth);
        return response()->json($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function refill(Request $request)
    {
        $features = $request->post('features');

        if($features) {
            foreach($features as $feature) {
                $properties = $feature['properties'];
                $berths = GuestBoatBerth::whereNumber($properties['number'])->first();
                if($berths) {
                    $berths->update($properties);
                } else {
                    unset($properties['id']);
                    GuestBoatBerth::create($properties);
                }
            }
        }

        return $this->index();
    }

    /**
     * @param StoreGuestBoatBerthRequest $request
     * @return JsonResponse
     */
    public function store(StoreGuestBoatBerthRequest $request)
    {
        $guestBoatBerth = GuestBoatBerth::create($request->validated());
        $data = new GuestBoatBerthGeoJsonResource($guestBoatBerth);
        return response()->json($data);
    }

    /**
     * @param UpdateGuestBoatBerthRequest $request
     * @param GuestBoatBerth $guestBoatBerth
     * @return JsonResponse
     */
    public function update(UpdateGuestBoatBerthRequest $request, GuestBoatBerth $guestBoatBerth)
    {
        $guestBoatBerth->update($request->validated());
        $data = new GuestBoatBerthGeoJsonResource($guestBoatBerth->refresh());
        return response()->json($data);
    }

    /**
     * @param GuestBoatBerth $guestBoatBerth
     * @return JsonResponse
     */
    public function destroy(GuestBoatBerth $guestBoatBerth)
    {
        $data = new GuestBoatBerthGeoJsonResource($guestBoatBerth);
        $guestBoatBerth->delete();
        return response()->json($data);
    }
}
