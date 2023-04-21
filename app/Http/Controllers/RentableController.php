<?php

namespace App\Http\Controllers;

use App\Helper\ModelHelper;
use App\Models\ConfigSetting;
use App\Repositories\CustomerRepository;
use App\Repositories\RentableRepository;
use App\Repositories\ConfigSaisonRentRepository;
use App\Repositories\ConfigSaisonRentDatesRepository;
use Illuminate\Support\Collection;

class RentableController extends Controller
{
    protected $paginatorLimit;
    protected $repository;
    protected $customerRepository;
    protected $configSaisonRentRepository;
    protected $configSaisonRentDatesRepository;
    protected $configSettings;
    protected $rentableRepository;
    protected $relation;
    protected $relationModel;
    protected string $relationName;
    protected Collection|null $rentableModels;
    protected string $routeName;

    public function __construct()
    {
        parent::__construct();
        $this->paginatorLimit                   = config('port.main.default.pagination.limit');
        $this->customerRepository               = new CustomerRepository();
        $this->configSaisonRentRepository       = new ConfigSaisonRentRepository();
        $this->configSaisonRentDatesRepository  = new ConfigSaisonRentDatesRepository();
        $this->rentableRepository               = new RentableRepository();
        $this->configSettings                   = ConfigSetting::first();
        $this->rentableModels                   = ModelHelper::allRentableModels();
        $this->relation                         = [$this->relationModel];
    }
}
