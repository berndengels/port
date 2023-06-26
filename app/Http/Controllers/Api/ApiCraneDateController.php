<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCraneDateRequest;
use App\Http\Requests\UpdateCraneDateRequest;
use App\Http\Resources\CraneDatesResource;
use App\Models\CraneDate;
use Illuminate\Http\Request;

class ApiCraneDateController extends Controller
{
    private $cranableTypeOptions = [
        ['id' => null, 'name' => 'Art wählen'],
        ['id' => 'App\\Models\\GuestBoat', 'name' => 'Gastboot'],
        ['id' => 'App\\Models\\Boat', 'name' => 'Dauerlieger']
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = CraneDate::with(['cranable'])->orderBy('crane_date')->get();
        $data = CraneDatesResource::collection($data);
        $response = [
            'dates' => $data,
            'cranableTypeOptions' => $this->cranableTypeOptions,
        ];

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CraneDate  $craneDate
     * @return \Illuminate\Http\Response
     */
    public function show(CraneDate $craneDate)
    {
        return response()->json($craneDate);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreCraneDateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCraneDateRequest $request)
    {
        try {
            $craneDate = CraneDate::create($request->validated());
            return response()->json([
				'craneDate'  => new CraneDatesResource($craneDate),
                'success' => "Krantermin erfolgreich angelegt!"
            ]);
        } catch(Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateCraneDateRequest  $request
     * @param  \App\Models\CraneDate  $craneDate
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCraneDateRequest $request, CraneDate $craneDate)
    {
        try {
            $craneDate->update($request->validated());
			$craneDate = $craneDate->refresh();

            return response()->json([
                'craneDate'  => new CraneDatesResource($craneDate),
                'success' => "Krantermin erfolgreich bearbeitet!"
            ]);
        } catch(Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CraneDate  $craneDate
     * @return \Illuminate\Http\Response
     */
    public function destroy(CraneDate $craneDate)
    {
        try {
            $data = $craneDate;
            $craneDate->delete();
            return response()->json([
				'craneDate'  => new CraneDatesResource($data),
                'success' => "Krantermin erfolgreich gelöscht!"
            ]);
        } catch(Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function cranable(Request $request)
    {
        $cranableType = $request->post('cranable_type');
        $data = $cranableType::orderBy('name')->get()->map(fn($k) => ['id' => $k->id, 'name' => $k->name]);

        return response()->json($data);
    }
}
