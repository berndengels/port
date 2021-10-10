<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BoatRequest;
use App\Models\Boat;
use App\Models\BoatType;
use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdminBoatController extends AdminController
{
    protected $boatTypes;

    public function __construct()
    {
        parent::__construct();
        $this->boatTypes = json_decode(config('port.main.boat.types'), true);
    }

    public function index()
    {
        $data = Boat::with('customer')->paginate($this->paginatorLimit);
        return view('admin.boats.index', compact('data'));
    }

    public function guests()
    {
        $data = Boat::with('customer')->paginate($this->paginatorLimit);
        return view('admin.boats.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param Boat $boat
     * @return Response
     */
    public function show(Boat $boat)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.boats.create', [
            'types' => $this->boatTypes,
            'customerOptions' => $this->customerOptionsAutocomplete,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BoatRequest $request
     * @return Response
     */
    public function store(BoatRequest $request)
    {
        $validated  = $request->validated();
        $name       = $request->post('name');
        try {
            $customer   = Customer::whereName($name)->first() ?? new Customer();
            $customer->fill($validated)->save();
            $customer->boats()->create($validated);
            return redirect()->route('admin.boats.index')->with('success', 'Boot erfogreich angelegt!');
        } catch(Exception $e) {
            return redirect()->route('admin.boats.create', $request)->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Boat $boat
     * @return Response
     */
    public function edit(Boat $boat)
    {
        return view('admin.boats.edit', [
            'boat'  => $boat,
            'types' => $this->boatTypes,
            'customerOptions' => $this->customerOptionsAutocomplete,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BoatRequest $request
     * @param Boat $boat
     * @return Response
     */
    public function update(BoatRequest $request, Boat $boat)
    {
        $validated  = $request->validated();
        $validatedBoat = collect($validated)->except(['name','fon','email','state'])->toArray();
        $validatedCustomer = collect($validated)->only(['name','fon','email','state'])->toArray();
        try {
            $boat->update($validatedBoat);
            $boat->customer()->update($validatedCustomer);
            return redirect()->route('admin.boats.index')->with('success', 'Boot erfogreich bearbeitet!');
        } catch(Exception $e) {
            return redirect()->route('admin.boats.edit', $request)->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Boat $boat
     * @return Response
     */
    public function destroy(Boat $boat)
    {
        //
    }
}
