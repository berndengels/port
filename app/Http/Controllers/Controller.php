<?php

namespace App\Http\Controllers;

use App\Repositories\GuestBoatsRepository;
use App\Repositories\BoatRepository;
use App\Repositories\CaravanRepository;
use App\Repositories\CountryRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\MaterialRepository;
use App\Repositories\MaterialCategoryRepository;
use App\Repositories\PriceTypeRepository;
use App\Repositories\RoleRepository;
use App\Repositories\SaisonDatesRepository;
use App\Repositories\ServiceCategoryRepository;
use App\Repositories\ServiceRepository;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected $paginatorLimit;
    protected $boatRepository;
    protected $guestBoatRepository;
    protected $countryRepository;
    protected $caravanRepository;
    protected $customerRepository;
    protected $roleRepository;
    protected $priceTypeRepository;
    protected $materialRepository;
    protected $materialCategoryRepository;
    protected $serviceCategoryRepository;
    protected $serviceRepository;
    protected $saisonDatesRepository;

    public function __construct()
    {
        $this->paginatorLimit = config('port.main.default.pagination.limit');
        $this->countryRepository    = new CountryRepository();
        $this->caravanRepository    = new CaravanRepository();
        $this->customerRepository   = new CustomerRepository();
        $this->roleRepository       = new RoleRepository();
        $this->boatRepository       = new BoatRepository();
        $this->guestBoatRepository  = new GuestBoatsRepository();
        $this->priceTypeRepository  = new PriceTypeRepository();
        $this->materialRepository   = new MaterialRepository();
        $this->materialCategoryRepository   = new MaterialCategoryRepository();
        $this->serviceCategoryRepository    = new ServiceCategoryRepository();
        $this->serviceRepository    = new ServiceRepository();
        $this->saisonDatesRepository = new SaisonDatesRepository();
    }
}
