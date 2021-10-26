<?php
namespace App\Http\Controllers\Admin;

use App\Libs\AppCache;
use App\Models\Customer;
use App\Models\Caravan;
use App\Models\Country;
use App\Models\Role;
use App\Repositories\BoatRepository;
use App\Repositories\CaravanRepository;
use App\Repositories\CountryRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\RoleRepository;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Collection;
use App\Filters\Caravan\CaravanFilter;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Event;

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
    /**
     * @var BoatRepository
     */
    protected $boatRepository;
    protected $countryRepository;
    protected $caravanRepository;
    protected $customerRepository;
    protected $roleRepository;

    public function __construct()
    {
//        $this->middleware(['auth:admin','auth:customer']);
        $this->paginatorLimit       = config('port.main.default.pagination.limit');
        $this->countryRepository    = new CountryRepository();
        $this->caravanRepository    = new CaravanRepository();
        $this->customerRepository   = new CustomerRepository();
        $this->roleRepository       = new RoleRepository();
        $this->boatRepository       = new BoatRepository();
    }
}
