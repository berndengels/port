<?php
namespace App\Http\Controllers\Admin;

use App\Models\GuestBoat;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\GuestBoatRequest;

/**
 * @todo: neue optionale bootseigenschaften: Bootstype, gewicht, tiefgang
 */
class AdminGuestBoatController extends AdminController
{
	protected $boatTypes;
	public function __construct()
	{
		parent::__construct();
		$this->boatTypes = config('port.main.boat.types');
	}

	/**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $guestBoat = $request->post('guestBoat');
        $data = GuestBoat::orderBy('name')
            ->guestBoat($guestBoat)
            ->paginate($this->paginatorLimit)
        ;

        return view('admin.guestBoats.index', [
            'guestBoatOptions' => $this->guestBoatRepository->options()->getSelectOptions()->prepend('Bitte wählen', null),
            'data'  => $data,
            'guestBoat' => $guestBoat,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  GuestBoat $guestBoat
     * @return Response
     */
    public function show(GuestBoat $guestBoat)
    {
        return view('admin.guestBoats.show', compact('guestBoat'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.guestBoats.create', [
			'types' => $this->boatTypes,
		]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  GuestBoatRequest $request
     * @return Response
     */
    public function store(GuestBoatRequest $request)
    {
        try {
            GuestBoat::create($request->validated());
            return redirect()->route('admin.guestBoats.index')->with('success', 'Gastboot erfolgreich angelegt!');
        } catch(Exception $e) {
            return redirect()->route('admin.guestBoats.create', $request)->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  GuestBoat $guestBoat
     * @return Response
     */
    public function edit(GuestBoat $guestBoat)
    {
        return view('admin.guestBoats.edit', [
			'guestBoat'	=> $guestBoat,
			'types' => $this->boatTypes,
		]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  GuestBoatRequest $request
     * @param  GuestBoat        $boatGuest
     * @return Response
     */
    public function update(GuestBoatRequest $request, GuestBoat $guestBoat)
    {
        $validated  = $request->validated();
        try {
            $guestBoat->update($validated);
            return redirect()->route('admin.guestBoats.index')->with('success', 'Gastboot erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return redirect()->route('admin.guestBoats.create', $request)->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  GuestBoat $guestBoat
     * @return Response
     */
    public function destroy(GuestBoat $guestBoat)
    {
        try {
            $guestBoat->delete();
            return redirect()->route('admin.guestBoats.index')->with('success', 'Gastboot erfolgreich gelöscht!');
        } catch(Exception $e) {
            return redirect()->route('admin.guestBoats.index')->with('error', $e->getMessage());
        }
    }
}
