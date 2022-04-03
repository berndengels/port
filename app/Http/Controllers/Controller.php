<?php

namespace App\Http\Controllers;

use App\Repositories\ConfigEntityTypesRepository;
use App\Repositories\ConfigHolidayRepository;
use App\Repositories\ConfigPriceComponentRepository;
use App\Repositories\ConfigSaisonRentDatesRepository;
use App\Repositories\ConfigSaisonRentRepository;
use App\Repositories\ConfigServiceRepository;
use App\Repositories\GuestBoatsRepository;
use App\Repositories\BoatRepository;
use App\Repositories\CaravanRepository;
use App\Repositories\CountryRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\HouseboatModelRepository;
use App\Repositories\MaterialRepository;
use App\Repositories\MaterialCategoryRepository;
use App\Repositories\ConfigPriceTypeRepository;
use App\Repositories\RoleRepository;
use App\Repositories\ConfigSaisonDatesRepository;
use App\Repositories\ServiceCategoryRepository;
use App\Repositories\ServiceRepository;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected $paginatorLimit;
    protected $boatRepository;
    protected $houseboatModelRepository;
    protected $guestBoatRepository;
    protected $countryRepository;
    protected $caravanRepository;
    protected $customerRepository;
    protected $roleRepository;
    protected $materialRepository;
    protected $materialCategoryRepository;
    protected $serviceCategoryRepository;
    protected $serviceRepository;
    protected $configServiceRepository;
    protected $configPriceComponentRepository;
    protected $configEntityTypeRepository;
    protected $configPriceTypeRepository;
    protected $configSaisonDatesRepository;
    protected $configSaisonRentRepository;
    protected $configSaisonRentDatesRepository;
    protected $configHolidayRepository;

    public function __construct()
    {
        $this->paginatorLimit = config('port.main.default.pagination.limit');
        $this->countryRepository    = new CountryRepository();
        $this->caravanRepository    = new CaravanRepository();
        $this->customerRepository   = new CustomerRepository();
        $this->roleRepository       = new RoleRepository();
        $this->boatRepository       = new BoatRepository();
        $this->houseboatModelRepository = new HouseboatModelRepository();
        $this->guestBoatRepository  = new GuestBoatsRepository();
        $this->materialRepository   = new MaterialRepository();
        $this->materialCategoryRepository       = new MaterialCategoryRepository();
        $this->serviceCategoryRepository        = new ServiceCategoryRepository();
        $this->serviceRepository    = new ServiceRepository();
        $this->configPriceTypeRepository        = new ConfigPriceTypeRepository();
        $this->configServiceRepository          = new ConfigServiceRepository();
        $this->configPriceComponentRepository   = new ConfigPriceComponentRepository();
        $this->configEntityTypeRepository       = new ConfigEntityTypesRepository();
        $this->configSaisonDatesRepository      = new ConfigSaisonDatesRepository();
        $this->configSaisonRentRepository       = new ConfigSaisonRentRepository();
        $this->configSaisonRentDatesRepository  = new ConfigSaisonRentDatesRepository();
        $this->configHolidayRepository          = new ConfigHolidayRepository();
    }
}
