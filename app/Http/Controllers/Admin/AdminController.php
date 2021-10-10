<?php
namespace App\Http\Controllers\Admin;

use App\Models\Customer;
use App\Models\Caravan;
use App\Models\Country;
use App\Models\Role;
use Illuminate\Support\Collection;
use App\Filters\Caravan\CaravanFilter;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class AdminController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var Collection
     */
    protected $countries;
    /**
     * @var Collection
     */
    protected $caravanOptions;
    protected $caravanOptionsAutocomplete;
    protected $customerOptions;
    protected $customerOptionsAutocomplete;

    /**
     * @var Collection
     */
    protected $roles;
    /**
     * @var Collection
     */
    protected $rolesOptions;
    protected $paginatorLimit;

    public function __construct()
    {
//        $this->middleware(['auth:admin','auth:customer']);
        $this->paginatorLimit = config('port.main.default.pagination.limit');
        // @todo: set cache for countries
        $this->countries = Country::orderBy('de')
            ->get(['id','de'])
            ->keyBy('id')
            ->map
            ->de
            ->prepend('Land wählen','')
        ;
        $caravans = Caravan::orderBy('carnumber')->get();
        $this->caravanOptionsAutocomplete = $caravans;
        // @todo: set cache for caravanOptions
        $this->caravanOptions = $caravans
            ->keyBy('id')
            ->map
            ->carnumber
            ->prepend('Kennzeichen wählen','')
        ;

        $customers = Customer::orderBy('name')->get();
        $this->customerOptionsAutocomplete = $customers;

        $this->customerOptions = $customers
            ->keyBy('id')
            ->map
            ->name
            ->prepend('Namen wählen','')
        ;

        $this->roles = Role::all();
        $this->rolesOptions = $this->roles->keyBy('id')->map->name;
    }

/*
    public function main()
    {
        if(!auth('customer')->check()) {
            return redirect()->route('public.dashboard');
        }
        return view('layouts.main');
    }
*/
}
