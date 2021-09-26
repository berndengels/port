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
        $caravanId = $request->post('caravan');

        $data = Caravan::orderBy('carnumber')
            ->caravan($caravanId)
            ->paginate(config('port.default.pagination.limit'))
        ;

        return view('admin.caravans.index', [
            'caravanOptions' => $this->caravanOptions,
            'data'  => $data,
            'id'    => $caravanId,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Caravan $caravan
     * @return Response
     */
    public function show(Caravan $caravan) {
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
            'countries' => $this->countries,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(CaravanRequest $request)
    {
        Caravan::create($request->validated());
        return Redirect::route('admin.caravans.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Caravan $caravan
     * @return Response
     */
    public function edit(Caravan $caravan)
    {
        $countries = $this->countries;
        return view('admin.caravans.edit', compact('caravan','countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CaravanRequest $request
     * @param Caravan $caravan
     * @return Response
     */
    public function update(CaravanRequest $request, Caravan $caravan)
    {
        $caravan->update($request->validated());
        return Redirect::route('admin.caravans.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Caravan $caravan
     * @return Response
     */
    public function destroy(Caravan $caravan)
    {
        $caravan->delete();
        return Redirect::route('admin.caravans.index');
    }
}
