<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Boat;
use App\Models\BoatType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\CustomerBoatRequest;

class BoatController extends Controller
{
    protected $boatTypes;

    public function __construct()
    {
        $this->boatTypes = collect(config('port.main.boat.types'))->prepend('bitte wählen', null);
    }

    public function index()
    {
        $data = Boat::whereCustomerId(auth('customer')->user()->id)->paginate($this->paginatorLimit);
        return view('customer.boats.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Boat $boat
     * @return Response
     */
    public function show(Boat $boat, Request $request)
    {
        if($request->isXmlHttpRequest() && $request->wantsJson()) {
            return response()->json($boat);
        }
        return view('customer.boats.show', compact('boat'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view(
            'customer.boats.create', [
            'types' => $this->boatTypes,
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CustomerBoatRequest $request
     * @return Response
     */
    public function store(CustomerBoatRequest $request)
    {
        $validated  = $request->validated();
        try {
            $customer = $request->user('customer');
            $customer->boats()->create($validated);
            return redirect()->route('customer.boats.index')->with('success', 'Boot erfolgreich angelegt!');
        } catch(Exception $e) {
            return redirect()->route('customer.boats.create', $request)->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Boat $boat
     * @return Response
     */
    public function edit(Boat $boat)
    {
        return view(
            'customer.boats.edit', [
            'boat'  => $boat,
            'types' => $this->boatTypes,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CustomerBoatRequest $request
     * @param  Boat        $boat
     * @return Response
     */
    public function update(CustomerBoatRequest $request, Boat $boat)
    {
        $validated  = $request->validated();
        try {
            $boat->update($validated);
            return redirect()->route('customer.boats.index')->with('success', 'Boot erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return redirect()->route('customer.boats.edit', $request)->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Boat $boat
     * @return Response
     */
    public function destroy(Boat $boat)
    {
        try {
            $boat->delete();
            return redirect()->route('customer.boats.index')->with('success', 'Boot erfolgreich gelöscht!');
        } catch(Exception $e) {
            return redirect()->route('customer.boats.index')->with('error', $e->getMessage());
        }
    }
}
