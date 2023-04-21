<?php

namespace App\Http\Controllers\Admin;

use App\Models\Berth;
use App\Models\Dock;
use Illuminate\Http\Response;
use App\Http\Requests\StoreDockRequest;
use App\Http\Requests\UpdateDockRequest;

class AdminDockController extends AdminController
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
        $data = Dock::paginate($this->paginatorLimit);
        $countBerths = Berth::count();
        return view('admin.docks.index', compact('data','countBerths'));
    }

    /**
     * Display the specified resource.
     *
     * @param Dock $dock
     * @return Response
     */
    public function show(Dock $dock)
    {
        return view('admin.docks.show', compact('dock'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.docks.create', [
            'dockNumbers'   => $this->dockNumbers,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreDockRequest  $request
     * @return Response
     */
    public function store(StoreDockRequest $request)
    {
        try {
            Dock::create($request->validated());
            return redirect()->route('admin.docks.index')->with('success', 'Bootssteg erfolgreich angelegt!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Dock $dock
     * @return Response
     */
    public function edit(Dock $dock)
    {
        return view('admin.docks.edit', [
            'dock'  => $dock,
            'dockNumbers'   => $this->dockNumbers,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateDockRequest $request
     * @param Dock $dock
     * @return Response
     */
    public function update(UpdateDockRequest $request, Dock $dock)
    {
        try {
            $dock->update($request->validated());
            return redirect()->route('admin.docks.index')->with('success', 'Bootssteg erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Dock $dock
     * @return Response
     */
    public function destroy(Dock $dock)
    {
        try {
            $dock->delete();
            return redirect()->route('admin.docks.index')->with('success', 'Bootssteg erfolgreich gelöscht!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
