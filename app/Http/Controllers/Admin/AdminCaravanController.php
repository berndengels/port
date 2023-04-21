<?php
namespace App\Http\Controllers\Admin;

use App\Filters\Caravan\CaravanFilter;
use App\Models\Caravan;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Collection;
use Illuminate\Http\Response;
use App\Http\Requests\CaravanRequest;
use Illuminate\Support\Facades\Redirect;

class AdminCaravanController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $id = $request->post('caravan');
        $data = Caravan::sortable()
            ->caravan($id)
            ->paginate(config('port.main.default.pagination.limit'));

        return view('admin.caravans.index', [
            'caravanOptions' => $this->caravanRepository->options('carnumber')->getSelectOptions()->prepend('Kennzeichen wählen', null),
            'data'  => $data,
            'id'    => $id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Caravan $caravan
     * @return Response
     */
    public function show(Caravan $caravan)
    {
        // @todo: show caravanDates and price data, sum prices
        return view('admin.caravans.show', compact('caravan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.caravans.create', [
                'countries' => $this->countryRepository->options('de')->getSelectOptions(),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(CaravanRequest $request)
    {
        try {
            Caravan::create($request->validated());
            return redirect()->route('admin.caravans.index')->with(['success' => "Caravan erfolgreich angelegt"]);
        } catch(Exception $e) {
            return back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Caravan $caravan
     * @return Response
     */
    public function edit(Caravan $caravan)
    {
        $countries = $this->countryRepository->options('de')->getSelectOptions();
        return view('admin.caravans.edit', compact('caravan', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CaravanRequest $request
     * @param  Caravan        $caravan
     * @return Response
     */
    public function update(CaravanRequest $request, Caravan $caravan)
    {
        try {
            $caravan->update($request->validated());
            return redirect()->route('admin.caravans.index')->with(['success' => "Caravan erfolgreich bearbeitet"]);
        } catch(Exception $e) {
            return back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Caravan $caravan
     * @return Response
     */
    public function destroy(Caravan $caravan)
    {
        try {
            $carnumber = $caravan->carnumber;
            $caravan->delete();
            return redirect()->route('admin.caravans.index')->with(['success' => "Caravan $carnumber erfolgreich gelöscht!"]);
        } catch(Exception $e) {
            return back()->with(['error' => $e->getMessage()]);
        }
    }
}
