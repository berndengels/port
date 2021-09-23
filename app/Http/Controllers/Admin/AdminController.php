<?php
namespace App\Http\Controllers\Admin;

use App\Models\Caravan;
use App\Models\Country;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Collection;

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
    protected $caravanOptionsJson;

    public function __construct()
    {
        $this->countries = Country::orderBy('de')
            ->get(['id','de'])
            ->keyBy('id')
            ->map
            ->de
        ;
        $caravans = Caravan::orderBy('carnumber')->get();

        $this->caravanOptions = $caravans
            ->keyBy('id')
            ->map
            ->carnumber;

        $this->caravanOptions->prepend('Kennzeichen suchen','');
        $this->caravanOptionsAutocomplete = $caravans;
    }

    public function main()
    {
        if(!auth()->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('layouts.main');
    }
}
