<?php

namespace App\Libs\Prices\Caravan;

abstract class Main
{
    protected $carLength;
    protected $useElectric = false;
    protected $persons = 0;
    protected $individualPrice = 0;
    protected $saisonFromMonth;
    protected $saisonUntilMonth;
    protected $defaultPricePerDay;
    protected $saisonPricePerDay;
    protected $priceElectricPerDay;
    protected $personsInclusive = 0;
    protected $personsAdditional = 0;

    protected function initConfg()
    {
        $this->saisonFromMonth      = config('port.main.dates.saison.fromMonth');
        $this->saisonUntilMonth     = config('port.main.dates.saison.untilMonth');
        $this->defaultPricePerDay   = config('port.prices.caravan.default_per_day');
        $this->saisonPricePerDay    = config('port.prices.caravan.saison_per_day');
        $this->priceElectricPerDay  = config('port.prices.caravan.electric_per_day');
        $this->personsInclusive     = config('port.prices.caravan.persons_inclusivce');
        $this->personsAdditional    = config('port.prices.caravan.persons_additional');
    }
}
