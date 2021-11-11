<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Response;
use App\Models\ServiceRequest;
use App\Http\Requests\ServiceRequestRequest;

class ServiceRequestController extends Controller
{
    protected $services;

    public function __construct()
    {
        parent::__construct();
        $this->services = $this->serviceRepository->options()->getSelectOptions();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = ServiceRequest::whereCustomerId(auth('customer')->user()->id)
            ->paginate($this->paginatorLimit)
        ;
        return view('customer.serviceRequests.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param  ServiceRequest  $serviceRequest
     * @return Response
     */
    public function show(ServiceRequest $serviceRequest)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Http\Response
     */
    public function create()
    {
        return view('customer.serviceRequests.create', [
            'services'  => $this->services,
        ]);
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
            $request->user('customer')
                ->serviceRequests()
                ->create($request->validated());

            return redirect()->route('customer.serviceRequests.index')->with('success', 'Service Anfrage erfogreich angelegt!');
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
        return view('customer.serviceRequests.edit', [
            'serviceRequest'  => $serviceRequest,
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
        if($serviceRequest->customer->id !== $request->user()->id) {
            throw new Exception('wrong ownership');
        }
        try {
            $serviceRequest->update($request->validated());
            return redirect()->route('customer.serviceRequests.index')->with('success', 'Service Anfrage erfogreich bearbeitet!');
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
            return redirect()->route('customer.serviceRequests.index')->with('success', 'Service Anfrage erfogreich gelöscht!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
