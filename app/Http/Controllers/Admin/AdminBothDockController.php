<?php

namespace App\Http\Controllers\Admin;

use App\Models\BoatDock;
use App\Http\Requests\StoreBoatDockRequest;
use App\Http\Requests\UpdateBoatDockRequest;
use Illuminate\Http\Response;

class AdminBothDockController extends AdminController
{
    private $dockNumbers;

    public function __construct()
    {
        parent::__construct();
        $this->dockNumbers = collect(range('A','Z'))
            ->keyBy(fn($item) => $item)
            ->prepend('Stegnummer wählen', '')
            ->toArray()
        ;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = BoatDock::paginate($this->paginatorLimit);
        return view('admin.boatDocks.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param BoatDock $bothDock
     * @return Response
     */
    public function show(BoatDock $boatDock)
    {
        return view('admin.boatDocks.show', compact('boatDock'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.boatDocks.create', [
            'dockNumbers'   => $this->dockNumbers,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreBoatDockRequest  $request
     * @return Response
     */
    public function store(StoreBoatDockRequest $request)
    {
        try {
            BoatDock::create($request->validated());
            return redirect()->route('admin.boatDocks.index')->with('success', 'Bootssteg erfolgreich angelegt!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param BoatDock $bothDock
     * @return Response
     */
    public function edit(BoatDock $boatDock)
    {
        return view('admin.boatDocks.edit', [
            'boatDock'  => $boatDock,
            'dockNumbers'   => $this->dockNumbers,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateBoatDockRequest $request
     * @param BoatDock $bothDock
     * @return Response
     */
    public function update(UpdateBoatDockRequest $request, BoatDock $boatDock)
    {
        try {
            $boatDock->update($request->validated());
            return redirect()->route('admin.boatDocks.index')->with('success', 'Bootssteg erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param BoatDock $bothDock
     * @return Response
     */
    public function destroy(BoatDock $boatDock)
    {
        try {
            $boatDock->delete();
            return redirect()->route('admin.boatDocks.index')->with('success', 'Bootssteg erfolgreich gelöscht!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
