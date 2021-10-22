<?php
namespace App\Http\Controllers\Admin;

use App\Models\Customer;
use App\Models\Caravan;
use App\Models\Country;
use App\Models\Role;
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

    public function __construct()
    {
//        $this->middleware(['auth:admin','auth:customer']);
        $this->paginatorLimit = config('port.main.default.pagination.limit');
        $this->countries = CountryRepository::options('de');

        $this->caravanOptionsAutocomplete = CaravanRepository::optionsData('carnumber');
        $this->caravanOptions = CaravanRepository::options('carnumber');

        $this->customerOptionsAutocomplete = CustomerRepository::optionsData();
        $this->customerOptions = CustomerRepository::options()->prepend('Namen wählen','');

        $this->rolesOptions = RoleRepository::options();
    }
}
