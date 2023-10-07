<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCraneDateRequest;
use App\Http\Requests\UpdateCraneDateRequest;
use App\Models\Boat;
use App\Models\CraneDate;
use App\Models\GuestBoat;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdminCraneDateController extends Controller
{
    private $cranableTypeOptions = [
        ''  => 'Art wählen',
        'App\\Models\\GuestBoat'  => 'Gastboot',
        'App\\Models\\Boat'  => 'Dauerlieger',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = CraneDate::paginate($this->paginatorLimit);
        return view('admin.craneDates.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param CraneDate $craneDate
     * @return Response
     */
    public function show(CraneDate $craneDate)
    {
        return view('admin.craneDates.show', compact('craneDate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.craneDates.create', [
            'cranableTypeOptions'   => $this->cranableTypeOptions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreCraneDateRequest  $request
     * @return Response
     */
    public function store(StoreCraneDateRequest $request)
    {
        try {
            CraneDate::create($request->validated());
            return redirect()->route('admin.craneDates.index')->with(['success' => "Krantermin erfolgreich erstellt!"]);
        } catch(Exception $e) {
            return back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param CraneDate $craneDate
     * @return Response
     */
    public function edit(CraneDate $craneDate)
    {
        return view('admin.craneDates.create', [
            'craneDate'    => $craneDate,
            'cranableTypeOptions'   => $this->cranableTypeOptions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateCraneDateRequest  $request
     * @param CraneDate $craneDate
     * @return Response
     */
    public function update(UpdateCraneDateRequest $request, CraneDate $craneDate)
    {
        try {
            $craneDate->update($request->validated());
            return redirect()->route('admin.craneDates.index')->with(['success' => "Krantermin erfolgreich bearbeitet!"]);
        } catch(Exception $e) {
            return back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CraneDate $craneDate
     * @return Response
     */
    public function destroy(CraneDate $craneDate)
    {
        try {
            $craneDate->delete();
            return redirect()->route('admin.craneDates.index')->with(['success' => "Krantermin erfolgreich gelöscht!"]);
        } catch(Exception $e) {
            return back()->with(['error' => $e->getMessage()]);
        }
    }

    public function cranable(Request $request)
    {
        $cranableType = $request->post('cranable_type');
        $data = $cranableType::orderBy('name')->get()->keyBy('id')->map->name;

        return response()->json($data);
    }
}
