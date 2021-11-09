<?php

namespace App\Http\Controllers;

use App\Repositories\BoatGuestsRepository;
use App\Repositories\BoatRepository;
use App\Repositories\CaravanRepository;
use App\Repositories\CountryRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\RoleRepository;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected $paginatorLimit;
    protected $boatRepository;
    protected $boatGuestRepository;
    protected $countryRepository;
    protected $caravanRepository;
    protected $customerRepository;
    protected $roleRepository;

    public function __construct()
    {
        $this->paginatorLimit = config('port.main.default.pagination.limit');
        $this->countryRepository    = new CountryRepository();
        $this->caravanRepository    = new CaravanRepository();
        $this->customerRepository   = new CustomerRepository();
        $this->roleRepository       = new RoleRepository();
        $this->boatRepository       = new BoatRepository();
        $this->boatGuestRepository  = new BoatGuestsRepository();
    }
}
