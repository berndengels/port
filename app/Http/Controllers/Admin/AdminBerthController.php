<?php

namespace App\Http\Controllers\Admin;

use App\Models\Berth;
use App\Http\Requests\StoreBerthRequest;
use App\Http\Requests\UpdateBerthRequest;
use App\Repositories\DockRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdminBerthController extends AdminController
{
    private $dockOptions;
    public function __construct(private DockRepository $dockRepository)
    {
        parent::__construct();
        $this->dockOptions = $this->dockRepository
            ->options()
            ->getSelectOptions()
            ->prepend('Bitte wählen ...');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = Berth::orderBy('number')->get();
        $data = json_encode($data);
        return view('admin.berths.vue-index', [
            'data'  => $data,
            'dockOptions'   => $this->dockOptions,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Berth $berth
     * @return Response
     */
    public function show(Berth $berth)
    {
        return view('admin.berths.show', compact('berth'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.berths.create', [
            'dockOptions' => $this->dockOptions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreBerthRequest  $request
     * @return Response
     */
    public function store(StoreBerthRequest $request)
    {
        try {
            Berth::create($request->validated());
            return redirect()->route('admin.berths.index')->with('success', 'Liegeplatz erfolgreich angelegt!');
        } catch(Exception $e) {
            return redirect()->route('admin.berths.create', $request)->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Berth $berth
     * @return Response
     */
    public function edit(Berth $berth)
    {
        return view('admin.berths.edit', [
            'berth' => $berth,
            'dockOptions' => $this->dockOptions
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateBerthRequest  $request
     * @param Berth $berth
     * @return Response
     */
    public function update(UpdateBerthRequest $request, Berth $berth)
    {
        try {
            $berth->update($request->validated());
            return redirect()->route('admin.berths.index')->with('success', 'Liegeplatz erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return redirect()->route('admin.berths.create', $request)->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Berth $berth
     * @return Response
     */
    public function destroy(Berth $berth)
    {
        // @todo: delete not work: No query results for model [App\Models\Berth] 4
        try {
            $berth->delete();
            return redirect()->route('admin.berths.index')->with('success', 'Liegeplatz erfolgreich gelöscht!');
        } catch(Exception $e) {
            return redirect()->route('admin.berths.index')->with('error', $e->getMessage());
        }
    }

    public function toggle(Berth $berth, Request $request)
    {
        if($request->isXmlHttpRequest()) {
            $attribute  = $request->post('attribute');
            $value      = (bool) $request->post('value');
            $berth->update([$attribute => $value]);
            $berth->refresh();
            return response()->json($berth);
        }
        return response()->json(['error' => 'no ajax request']);
    }
}
