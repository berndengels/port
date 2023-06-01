<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\ConfigEntity;
use App\Rules\RuleRentDateValidFrom;
use App\Rules\RuleRentDateValidUntil;
use App\Exports\RentalsExport;
use App\Mail\SendExcel;
use App\Models\HouseboatRentals;
use App\Models\Rentable;
use App\Http\Controllers\RentableController;
use App\Http\Requests\RentableRequest;
use App\Http\Requests\RentableRequestValidationData;
use App\Repositories\CalendarRentableRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AdminRentalsController extends RentableController
{
    protected array $years;
    protected array $monthsByYear;
    protected Collection $relationOptions;
    protected string $customerType = 'renter';
    protected Collection $customerOptions;
    protected $calendarDates;
    /**
     * @var Collection
     */
    protected Collection $dates;
    /**
     * @var Builder
     */
    protected Builder $rentable;

    public function __construct()
    {
        parent::__construct();
        if(isset($this->rentableModels[class_basename($this->relationModel)])) {
            $this->rentable = Rentable::whereHasMorph('rentable', $this->relation);
        } else {
            $this->rentable = Rentable::query();
        }
        $this->priceComponents = ConfigEntity::whereModel($this->relationModel)
            ->first()
            ->priceComponents
        ;

        $this->relationOptions = ($this->relationModel)::orderBy('name')
            ->get()
            ->keyBy('id')
            ->map->name
            ->prepend('Bitte wählen', null);

        $customers = $this->customerType
            ? $this->customerRepository->options(where: ['type' => $this->customerType])
            : $this->customerRepository->options();

        $this->customerOptions = $customers->getSelectOptions()
            ->prepend('Kunde wählen', null);

        $this->dates = $this->rentable->get();
        $this->calendarDates = (new CalendarRentableRepository($this->dates))->getJsonDates();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $filter = $request->input('filter');
        $from   = $request->input('from');
        $until  = $request->input('until');
        $sort   = $request->input('sort');
        $direction  = $request->input('direction');

        if($from) {
            $from = Carbon::make($from);
        }
        if($until) {
            $until = Carbon::make($until);
        }

        if($filter) {
            $from = null;
            $until = null;
        }

        /**
         * @var $query Builder
         */
        $query = $this->rentable;
        $firstDate = Carbon::make(Rentable::min('from'));
        $lastDate = Carbon::make(Rentable::max('until'));

        if(!$from && $firstDate) {
            $from = $firstDate;
        }
        if(!$until && $lastDate) {
            $until = $lastDate;
        }
        $query->whereBetween('rentables.from', [$from, $until]);

        if($filter) {
            $query->whereRentableId($filter);
        }

        /**
         * @var $priceTotal Collection
         */
        $priceTotal = $this->dates->sum(fn ($item) => (int) $item->price);

        if($sort) {
            $query->orderBy($sort, $direction);
        }

        $data = $query->paginate($this->paginatorLimit);
        $queryString = $request->only(['rentable','filter','from', 'until','sort']);

        return view('admin.rentals.index', [
            'rentable'          => $this->relationName,
            'calendarDates'     => $this->calendarDates,
            'initialDate'       => Carbon::today()->format('Y-m-d'),
            'relationOptions'   => $this->relationOptions,
            'filter'            => $filter,
            'data'              => $data ?? [],
            'priceTotal'        => $priceTotal,
            'routeName'         => $this->routeName,
            'from'              => $from,
            'until'             => $until,
            'firstDate'         => $firstDate,
            'lastDate'          => $lastDate,
            'queryString'       => $queryString,
        ]);
    }

    public function show(Rentable $rental)
    {
        $rental->load(['customer']);
        return view('admin.rentals.show', [
            'rental'        => $rental,
            'priceData'     => $rental->getPriceDataAttribute(),
            'relationName'  => $this->relationName,
            'routeName'     => $this->routeName,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.rentals.create', [
            'priceComponents'   => $this->priceComponents,
            'relationName'      => $this->relationName,
            'calendarDates'     => $this->calendarDates,
            'initialDate'       => Carbon::today()->format('Y-m-d'),
            'customerOptions'   => $this->customerOptions,
            'relationOptions'   => $this->relationOptions,
            'routeName'         => $this->routeName,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $id             = $request->post('rentable_id');
            $rentable       = ($this->relationModel)::find($id);
            $validationData = new RentableRequestValidationData($request);
            $request        = $validationData->getRequest();

            $rules  = $validationData->rules();
            $rules['from']  = array_merge($rules['from'], [new RuleRentDateValidFrom($rentable, $this->relation)]);
            $rules['until'] = array_merge($rules['until'], [new RuleRentDateValidUntil($rentable, $this->relation)]);

            $validator  = Validator::make($request->all(), $rules, $validationData->messages());
            $validator->validate();

            $rental = $rentable->rentals()->create($validator->validated());

            return redirect()->route('admin.'.$this->routeName.'.show', $rental)->with('success', 'Miet-Buchung erfolgreich angelegt!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit(Rentable $rental)
    {
        $this->dates = $this->rentable
            ->orderBy('from', 'desc')
            ->get();
        $this->calendarDates = (new CalendarRentableRepository($this->dates))->getJsonDates();

        return view('admin.rentals.edit', [
            'rental'            => $rental,
            'relationName'      => $this->relationName,
            'calendarDates'     => $this->calendarDates,
            'initialDate'       => $rental->from,
            'customerOptions'   => $this->customerOptions,
            'relationOptions'   => $this->relationOptions,
            'routeName'         => $this->routeName,
            'priceComponents'   => $this->priceComponents,
        ]);
    }

    public function update(RentableRequest $request, Rentable $rental)
    {
        try {
            $rules = $request->rules();
            $rules['from']  = array_merge($rules['from'], [new RuleRentDateValidFrom($rental->rentable, $this->relation)]);
            $rules['until'] = array_merge($rules['until'], [new RuleRentDateValidUntil($rental->rentable, $this->relation)]);
            $validator  = Validator::make($request->all(), $rules, $request->messages());
            $validator->validate();
            $rental->update($request->validated());
            return redirect()->route('admin.'.$this->routeName.'.index')->with('success', 'Buchung erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param HouseboatRentals $houseboatDate
     * @return Response
     */
    public function destroy(Rentable $rental)
    {
        try {
            $rental->delete();
            return redirect()->route('admin.'.$this->routeName.'.index')->with('success', 'Buchung erfolgreich gelöscht!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function printPage(Rentable $rental)
    {
        $priceData      = $rental->getPriceDataAttribute();
        return view('admin.rentals.print', compact('rental','priceData'));
    }

    public function sendExcel($rentable, Request $request)
    {
        $from       = $request->post('from');
        $until      = $request->post('until');
        if($from) {
            $from = Carbon::make($from);
        }
        if($until) {
            $until = Carbon::make($until);
        }
        $strFrom    = $from ? $from->format('d.m.Y') : 'Anfang';
        $strUntil   = $until ? $until->format('d.m.Y') : 'Ende';
        $now        = Carbon::now()->format('Ymd-Hi');
        $typ        = __(ucfirst($rentable));
        $fileName   = $now.'_'.$typ.'_dates.xls';
        $subject    = "Umsatz-Daten für $typ ($strFrom - $strUntil)";

        try {
            $export = new RentalsExport($rentable, $from, $until);
            Mail::send(new SendExcel(
                recipient:  $request->post('email'),
                export: $export,
                fileName: $fileName,
                subject: $subject,
                dateFrom: $from,
                dateUntil: $until
            ));
            return redirect()->route('admin.'.$this->routeName.'.index')->with(['success' => 'Excel-Datei erfolgreich versand!']);
        } catch (Exception $e) {
            return redirect()->route('admin.'.$this->routeName.'.index')->with(['error' => 'Excel-Datei konnte nicht versand werden!']);
        }
    }

    public function sendInvoice(Rentable $rental)
    {
        return 'work in progress';
    }

    public function toggle(Rentable $rental, Request $request)
    {
        if($request->isXmlHttpRequest()) {
            $attribute  = $request->post('attribute');
            $value      = (bool) $request->post('value');
            $rental->update([$attribute => $value]);
            $rental->refresh();
            return response()->json($rental);
        }
        return response()->json(['error' => 'no ajax request']);
    }
}
