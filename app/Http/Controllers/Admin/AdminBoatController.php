<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BoatRequest;
use App\Models\Boat;
use App\Models\BoatType;
use App\Models\Customer;
use App\Models\Media;
use App\Repositories\BerthRepository;
use App\Repositories\CustomerRepository;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdminBoatController extends AdminController
{
    protected $boatTypes;
    protected $customerOptions;
    protected $berthOptions;

    public function __construct()
    {
		parent::__construct();
        $this->boatTypes = config('port.main.boat.types');
        $this->customerOptions = $this->customerRepository->options(where: ['type' => 'permanent'])->getSelectOptionsData()->prepend('bitte wählen', null);
        $this->berthOptions = $this->berthRepository->optionsData()->prepend('bitte wählen', null);
    }

    public function index()
    {
        $data = Boat::with('berth')->sortable()->whereHas(
                'customer', function (Builder $query) {
                    $query->where('type', '=', 'permanent');
                }
            )
            ->paginate($this->paginatorLimit);
        return view('admin.boats.index', compact('data'));
    }

    public function guests()
    {
        $data = Boat::with('customer')->sortable()
            ->whereHas(
                'customer', function (Builder $query) {
                    $query->where('type', '=', 'guest');
                }
            )
            ->paginate($this->paginatorLimit);
        return view('admin.boats.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Boat $boat
     * @return Response
     */
    public function show(Boat $boat, Request $request)
    {
		$boat->load('media');
        if($request->isXmlHttpRequest() && $request->wantsJson()) {
            return response()->json($boat);
        }
        return view('admin.boats.show', compact('boat'));
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
                'customerOptions'   => $this->customerOptions->toJson(),
                'berthOptions'      => $this->berthOptions,
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BoatRequest $request
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

            return redirect()->route('admin.boats.index')->with('success', 'Boot erfolgreich angelegt!');
        } catch(Exception $e) {
            return redirect()->route('admin.boats.create', $request)->with('error', $e->getMessage());
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
		$boat->load(['media']);
		$files = $boat->getMedia('boat')->map(fn(Media $m) => [
			'id'=> $m->id,
			'name' => $m->name,
			'url'  => $m->getUrl('thumb')
		])->toJson(true);

        return view('admin.boats.edit', [
                'boat'  => $boat,
                'types' => $this->boatTypes,
				'files' => $files,
                'customerOptions' => $this->customerOptions,
                'berthOptions'    => $this->berthOptions,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  BoatRequest $request
     * @param  Boat        $boat
     * @return Response
     */
    public function update(BoatRequest $request, Boat $boat)
    {
        $validated  = $request->validated();
        try {
            $boat->update($validated);
            return redirect()->route('admin.boats.index')->with('success', 'Boot erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return redirect()->route('admin.boats.edit', $request)->with('error', $e->getMessage());
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
			$boat->media()->each(fn(Media $m) => $boat->deleteMedia($m->id));
            $boat->delete();
            return redirect()->route('admin.boats.index')->with('success', 'Boot erfolgreich gelöscht!');
        } catch(Exception $e) {
            return redirect()->route('admin.boats.index')->with('error', $e->getMessage());
        }
    }
}
