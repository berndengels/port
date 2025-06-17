<?php

namespace App\Http\Controllers;

use App\Models\Berth;
use App\Repositories\ApartmentModelRepository;
use App\Repositories\ApartmentRepository;
use App\Repositories\BerthRepository;
use App\Repositories\ConfigEntityTypesRepository;
use App\Repositories\ConfigHolidayRepository;
use App\Repositories\ConfigOffersRepository;
use App\Repositories\ConfigPriceComponentRepository;
use App\Repositories\ConfigSaisonRentDatesRepository;
use App\Repositories\ConfigSaisonRentRepository;
use App\Repositories\ConfigServiceRepository;
use App\Repositories\ConfigUnitRangeTypeRepository;
use App\Repositories\GuestBoatsRepository;
use App\Repositories\BoatRepository;
use App\Repositories\CaravanRepository;
use App\Repositories\CountryRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\HouseboatModelRepository;
use App\Repositories\HouseboatOwnerRepository;
use App\Repositories\HouseboatRepository;
use App\Repositories\HouseModelRepository;
use App\Repositories\HouseRepository;
use App\Repositories\MaterialRepository;
use App\Repositories\MaterialCategoryRepository;
use App\Repositories\ConfigPriceTypeRepository;
use App\Repositories\RentableRepository;
use App\Repositories\RoleRepository;
use App\Repositories\ConfigSaisonDatesRepository;
use App\Repositories\ServiceCategoryRepository;
use App\Repositories\ServiceRepository;
use App\Repositories\GuestBoatBerthRepository;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected $paginatorLimit;
    protected $boatRepository;
    protected $berthRepository;
    protected $houseboatModelRepository;
    protected $houseboatOwnerRepository;
    protected $houseboatRepository;
    protected $guestBoatBerthRepository;
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
	protected $configUnitRangeTypeRepository;
    protected $configSaisonDatesRepository;
    protected $configSaisonRentRepository;
    protected $configSaisonRentDatesRepository;
    protected $configHolidayRepository;
    protected $configSettings;
    protected $rentableRepository;
    protected $apartmentRepository;
    protected $apartmentModelRepository;

    protected $houseRepository;
    protected $houseModelRepository;
    protected $configOffers;
    protected $useTax;
    protected $tax;
    protected $berthHasPrice = false;

    public function __construct()
    {
        $this->paginatorLimit = config('port.main.default.pagination.limit');
        $this->countryRepository    = new CountryRepository();
        $this->caravanRepository    = new CaravanRepository();
        $this->customerRepository   = new CustomerRepository();
        $this->roleRepository       = new RoleRepository();
        $this->boatRepository       = new BoatRepository();
        $this->berthRepository      = new BerthRepository();
        $this->serviceRepository    = new ServiceRepository();
        $this->guestBoatBerthRepository         = new GuestBoatBerthRepository();
        $this->houseboatModelRepository         = new HouseboatModelRepository();
        $this->houseboatOwnerRepository         = new HouseboatOwnerRepository();
        $this->houseboatRepository              = new HouseboatRepository();
        $this->apartmentRepository              = new ApartmentRepository();
        $this->apartmentModelRepository         = new ApartmentModelRepository();
        $this->houseRepository                  = new HouseRepository();
        $this->houseModelRepository             = new HouseModelRepository();
        $this->guestBoatRepository              = new GuestBoatsRepository();
        $this->materialRepository               = new MaterialRepository();
        $this->materialCategoryRepository       = new MaterialCategoryRepository();
        $this->serviceCategoryRepository        = new ServiceCategoryRepository();
        $this->configPriceTypeRepository        = new ConfigPriceTypeRepository();
        $this->configServiceRepository          = new ConfigServiceRepository();
        $this->configPriceComponentRepository   = new ConfigPriceComponentRepository();
        $this->configEntityTypeRepository       = new ConfigEntityTypesRepository();
        $this->configSaisonDatesRepository      = new ConfigSaisonDatesRepository();
        $this->configSaisonRentRepository       = new ConfigSaisonRentRepository();
        $this->configSaisonRentDatesRepository  = new ConfigSaisonRentDatesRepository();
        $this->configHolidayRepository          = new ConfigHolidayRepository();
        $this->rentableRepository               = new RentableRepository();
        $this->configSettings                   = config('settings');
        $this->useTax                           = $this->configSettings?->use_tax ?? null;
        $this->tax                              = $this->configSettings?->tax ?? null;
		$this->configUnitRangeTypeRepository	= new ConfigUnitRangeTypeRepository();
        $this->configOffers                     = (new ConfigOffersRepository())
            ->options(where: ['enabled' => true])
            ->getSelectOptionsData()
            ->map(fn($item) => $item->model)
            ->toArray()
        ;
        $this->berthHasPrice = Berth::sum('daily_price') > 0;
    }
}
