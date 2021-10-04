<?php
namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Str;
use App\Models\Caravan;
use App\Models\Country;
use App\Models\Role;
use Illuminate\Http\Request;
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
        $this->middleware(['auth', 'auth:admin']);
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

        // @todo: set cache for caravanOptions
        $this->caravanOptions = $caravans
            ->keyBy('id')
            ->map
            ->carnumber
            ->prepend('Kennzeichen wählen','')
        ;

        $this->caravanOptionsAutocomplete = $caravans;

        $this->roles = Role::all();
        $this->rolesOptions = $this->roles->keyBy('id')->map->name;
    }

    public function main()
    {
        if(!auth()->check()) {
            return redirect()->route('public.dashboard');
        }
        return view('layouts.main');
    }
}
