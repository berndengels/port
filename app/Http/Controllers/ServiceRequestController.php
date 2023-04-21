<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Boat;
use App\Models\Customer;
use Illuminate\Http\Response;
use App\Models\ServiceRequest;
use App\Events\ServiceRequested;
use Illuminate\Database\Eloquent\Builder;
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
        /**
         * @var Customer $customer
         */
        $customer = auth('customer')->user();
        $boats = $customer->boats->map->id;
        $data = ServiceRequest::whereIn('boat_id', $boats)
            ->orderByDesc('created_at')
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
        $underwaterArea = $serviceRequest->boat->underwaterArea;
        $boardArea = $serviceRequest->boat->boardArea;
        return view('customer.serviceRequests.show', compact('serviceRequest','underwaterArea', 'boardArea'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Http\Response
     */
    public function create()
    {
        $customer = auth('customer')->user();
        $boats = $this->boatRepository
            ->setCustomer($customer)
            ->options(textFieldName: 'name', relations: 'serviceRequests')
            ->getSelectOptions()
        ;
        if(0 === $boats->count()) {
            return redirect()->route('customer.boats.create')
                ->with('success', 'Bitte tragen Sie erst Ihre Bootsdaten ein!');
        }

        return view('customer.serviceRequests.create', [
            'services'  => $this->services,
            'boats' => $boats,
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
            /**
             * @var Customer $customer
             */
            $customer = $request->user('customer');
            /**
             * @var ServiceRequest $serviceRequest
             */
            $serviceRequest = $customer
                ->boats()
                ->find($request->validated()['boat_id'])
                ->serviceRequests()
                ->create($request->validated())
            ;
            $serviceRequest
                ->services()
                ->sync($request->validated()['services'])
            ;

//            event(new ServiceRequested($serviceRequest->refresh(),'store'));

            return redirect()->route('customer.serviceRequests.index')->with('success', 'Service Anfrage erfolgreich angelegt!');
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
        $customer = auth('customer')->user();
        $boats = $this->boatRepository
            ->setCustomer($customer)
            ->options(textFieldName: 'name', relations: 'serviceRequests')
            ->getSelectOptions()
        ;

        return view('customer.serviceRequests.edit', [
            'serviceRequest'  => $serviceRequest,
            'services'  => $this->services,
            'boats' => $boats,
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
        if($serviceRequest->boat->customer->id !== $request->user()->id) {
            throw new Exception('wrong ownership');
        }
        try {
            $serviceRequest->update($request->validated());
            $serviceRequest->services()->sync($request->validated()['services']);

//            event(new ServiceRequested($serviceRequest->refresh(), 'update'));

            return redirect()->route('customer.serviceRequests.index')->with('success', 'Service Anfrage erfolgreich bearbeitet!');
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
            return redirect()->route('customer.serviceRequests.index')->with('success', 'Service Anfrage erfolgreich gelöscht!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function printPage(ServiceRequest $serviceRequest)
    {
        return view('customer.serviceRequests.print', compact('serviceRequest'));
    }
}
