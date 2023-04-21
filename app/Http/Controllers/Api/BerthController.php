<?php

namespace App\Http\Controllers\Api;

use Exception;
use Eloquent;
use App\Models\Berth;
use Database\Seeders\BerthMapSeeder;
use Database\Seeders\BerthSeeder;
use App\Http\Requests\StoreBerthRequest;
use App\Http\Requests\UpdateBerthRequest;
use App\Http\Resources\BerthGeoJsonResource;
use App\Models\BerthCategory;
use App\Models\BerthMap;
use App\Models\Dock;
use App\Models\ConfigSetting;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\BerthResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 *
 */
class BerthController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index()
    {
        $data = Berth::all()->sortBy('number', SORT_NATURAL);
        $data = BerthResource::collection($data);
        return response()->json($data);
    }
    public function loadBackup()
    {
        $seeder = new BerthSeeder();
        $seeder->run();
        $seeder = new BerthMapSeeder();
        $seeder->run();
        return $this->index();
    }
    public function saveBackup()
    {
        try {
            \Artisan::call('make:model-export berths');
            \Artisan::call('make:model-export berth_maps');
            return $this->index();
        } catch(Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * @return JsonResponse
     */
    public function docks()
    {
        $data = Dock::all()->sortBy('name', SORT_NATURAL);
        return response()->json($data);
    }

    /**
     * @return JsonResponse
     */
    public function port()
    {
        $data = ConfigSetting::firstOrFail();
        return response()->json($data);
    }

    /**
     * @return JsonResponse
     */
    public function categories()
    {
        $data = BerthCategory::all();
        return response()->json($data);
    }

    /**
     * @param Berth $berth
     * @return JsonResponse
     */
    public function show(Berth $berth)
    {
        $data = new BerthResource($berth);
        return response()->json($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function refill(Request $request)
    {
        $data = $request->post();
        if($data) {
            foreach($data as $point) {
                $berths = Berth::whereNumber($point['number'])
                    ->whereDockId($point['dock_id'])
                    ->first();

                if($berths) {
                    $berths->update($point);
                } else {
                    unset($point['id']);
                    Berth::create($point);
                }
            }
        }

        return $this->index();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function setPoints(Request $request)
    {
        $data = $request->post('points');
        if($data) {
            DB::table('berth_maps')->truncate();
            foreach($data as $point) {
                BerthMap::create($point);
            }
        }
        return response()->json($data);
    }

    /**
     * @param StoreBerthRequest $request
     * @return JsonResponse
     */
    public function store(StoreBerthRequest $request)
    {
        $berth = Berth::create($request->validated());
        $data = new BerthGeoJsonResource($berth);
        return response()->json($data);
    }

    /**
     * @param UpdateBerthRequest $request
     * @param Berth $berth
     * @return JsonResponse
     */
    public function update(UpdateBerthRequest $request, Berth $berth)
    {
        $berth->update($request->validated());
        $data = new BerthResource($berth->refresh());
        return response()->json($data);
    }

    /**
     * @param Berth $berth
     * @return JsonResponse
     */
    public function destroy(Berth $berth)
    {
        $data = new BerthResource($berth);
        $berth->delete();
        return response()->json($data);
    }

    /**
     * @param Berth $berth
     * @return JsonResponse
     */
    public function destroyAny(Request $request)
    {
        $ids = $request->post('any');
        if($ids && count($ids) > 0) {
            Berth::whereIn('id', $ids)->delete();
        }
        return $this->index();
    }

    /**
     * @param Berth $berth
     * @return JsonResponse
     */
    public function destroyAll()
    {
        try {
            Eloquent::unguard();
            Schema::disableForeignKeyConstraints();
            Berth::truncate();
            $result = ['errors' => null];
            Schema::enableForeignKeyConstraints();
        } catch(Exception $e) {
            $result = ['errors' => $e->getMessage()];
        }
        return response()->json($result);
    }
}
