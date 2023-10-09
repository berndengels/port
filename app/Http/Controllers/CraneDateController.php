<?php

namespace App\Http\Controllers;

use App\Models\AdminUser;
use App\Models\CraneDate;
use App\Http\Requests\StoreCraneDateRequest;
use App\Http\Requests\UpdateCraneDateRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Response;

class CraneDateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
		return view('customer.craneDates.index');
    }

    /**
     * Display the specified resource.
     *
     * @param CraneDate $craneDate
     * @return Response
     */
    public function show(CraneDate $craneDate)
    {
//		Carbon::setlocale('de_DE');
		$craneDate->load(['cranable']);
		return view('customer.craneDates.show', compact('craneDate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
		return view('customer.craneDates.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreCraneDateRequest  $request
     * @return Response
     */
    public function store(StoreCraneDateRequest $request)
    {
		try {
			CraneDate::create($request->validated());
			return redirect()->route('customer.craneDates.index')->with(['success' => "Krantermin erfolgreich erstellt!"]);
		} catch(Exception $e) {
			return back()->with(['error' => $e->getMessage()]);
		}
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param CraneDate $craneDate
     * @return Response
     */
    public function edit(CraneDate $craneDate)
    {
		return view('customer.craneDates.create', [
			'craneDate'    => $craneDate,
		]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateCraneDateRequest  $request
     * @param CraneDate $craneDate
     * @return Response
     */
    public function update(UpdateCraneDateRequest $request, CraneDate $craneDate)
    {
		try {
			$craneDate->update($request->validated());
			return redirect()->route('customer.craneDates.index')->with(['success' => "Krantermin erfolgreich bearbeitet!"]);
		} catch(Exception $e) {
			return back()->with(['error' => $e->getMessage()]);
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CraneDate $craneDate
     * @return Response
     */
    public function destroy(CraneDate $craneDate)
    {
		try {
			$craneDate->delete();
			return redirect()->route('customer.craneDates.index')->with(['success' => "Krantermin erfolgreich gelöscht!"]);
		} catch(Exception $e) {
			return back()->with(['error' => $e->getMessage()]);
		}
    }
}
