<?php

namespace App\Http\Controllers\Admin;

use App\Libs\Invoices\InvoiceServiceRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\ServiceRequest;
use App\Http\Requests\ServiceRequestRequest;

class AdminServiceRequestController extends AdminController
{
    protected $boats;
    protected $services;

    public function __construct()
    {
        parent::__construct();
        $this->boats = $this->boatRepository->options()->getSelectOptions();
        $this->services = $this->serviceRepository->options()->getSelectOptions();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = ServiceRequest::orderBy('created_at', 'desc')
            ->paginate($this->paginatorLimit)
        ;
        return view('admin.serviceRequests.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param  ServiceRequest  $serviceRequest
     * @return Response
     */
    public function show(ServiceRequest $serviceRequest)
    {
        $underwaterArea = $serviceRequest->boat->underwaterArea;
        $boardArea = $serviceRequest->boat->boardArea;
        return view('admin.serviceRequests.show', compact('serviceRequest','underwaterArea','boardArea'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ServiceRequestRequest $request
     * @return Response
     */
    public function store(ServiceRequestRequest $request)
    {
        try {
            ServiceRequest::create($request->validated());
            return redirect()->route('admin.serviceRequests.index')->with('success', 'Service Anfrage erfolgreich angelegt!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ServiceRequest  $serviceRequest
     * @return Response
     */
    public function edit(ServiceRequest $serviceRequest)
    {
        return view('admin.serviceRequests.edit', [
            'serviceRequest'  => $serviceRequest,
            'boats' => $this->boats,
            'services'  => $this->services,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ServiceRequestRequest $request
     * @param  ServiceRequest  $serviceRequest
     * @return Response
     */
    public function update(ServiceRequestRequest $request, ServiceRequest $serviceRequest)
    {
        try {
            $serviceRequest->update($request->validated());
            return redirect()->route('admin.serviceRequests.index')->with('success', 'Service Anfrage erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function done(Request $request, ServiceRequest $serviceRequest)
    {
        try {
            $serviceRequest->update(['done' => $request->post('done') ?? false]);
            return redirect()->route('admin.serviceRequests.index')->with('success', 'Service Anfrage als erledigt markiert!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ServiceRequest  $serviceRequest
     * @return Response
     */
    public function destroy(ServiceRequest $serviceRequest)
    {
        try {
            $serviceRequest->delete();
            return redirect()->route('admin.serviceRequests.index')->with('success', 'Service Anfrage erfolgreich gelöscht!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function toggle(ServiceRequest $serviceRequest, Request $request)
    {
        if($request->isXmlHttpRequest()) {
            $attribute  = $request->post('attribute');
            $value      = (bool) $request->post('value');
            try {
                $serviceRequest->update([$attribute => $value]);
                $serviceRequest->refresh();
                return response()->json($serviceRequest);
            } catch(Exception $e) {
                return response()->json(['error' => $e->getMessage()]);
            }
        }
        return response()->json(['error' => 'no ajax request']);
    }

    /**
     * Display the specified resource.
     *
     * @param  ServiceRequest  $serviceRequest
     * @return Response
     */
    public function printPage(ServiceRequest $serviceRequest)
    {
        $underwaterArea = $serviceRequest->boat->underwaterArea;
        $boardArea = $serviceRequest->boat->boardArea;
        return view('admin.serviceRequests.print', compact('serviceRequest','underwaterArea','boardArea'));
    }

}
