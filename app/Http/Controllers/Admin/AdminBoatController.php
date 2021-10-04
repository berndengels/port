<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BoatRequest;
use App\Models\Boat;
use App\Models\BoatType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdminBoatController extends AdminController
{
    protected $boatTypes;

    public function __construct()
    {
        $this->boatTypes = json_decode(config('port.main.boat.types'), true);
    }

    public function index()
    {
        $data = Boat::paginate($this->paginatorLimit);
        return view('admin.boats.index', compact('data'));
    }

    public function guests()
    {
        $data = Boat::paginate($this->paginatorLimit);
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Boat $boat
     * @return Response
     */
    public function edit(Boat $boat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Boat $boat
     * @return Response
     */
    public function update(Request $request, Boat $boat)
    {
        //
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
