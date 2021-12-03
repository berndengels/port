<?php

namespace App\Entities;

use Carbon\Carbon;
use Spatie\Period\Period;
use App\Models\ConfigSaisonDates;
use Illuminate\Support\Collection;

class SaisonDatesEntity
{
    /**
     * @var ConfigSaisonDates
     */
    protected $currentSaison;
    /**
     * @var Period
     */
    protected $period;

    /**
     * @var array
     */
    protected $dailyPrices = [];
    protected $price;

    public function __construct(protected ConfigSaisonDates $saison, protected Carbon $from, protected Carbon $until)
    {
    }

    public function getSaisonId() {
        return $this->saison->id;
    }

    public function getSaisonName() {
        return $this->saison->name;
    }

    /**
     * @return ConfigSaisonDates
     */
    public function getSaison(): ConfigSaisonDates
    {
        return $this->saison;
    }

    /**
     * @return Carbon
     */
    public function getFrom(): Carbon
    {
        return $this->from;
    }

    /**
     * @return Carbon
     */
    public function getUntil(): Carbon
    {
        return $this->until;
    }

    /**
     * @return ConfigSaisonDates
     */
    public function getCurrentSaison(): ConfigSaisonDates
    {
        return $this->currentSaison;
    }

    /**
     * @param ConfigSaisonDates $currentSaison
     * @return SaisonDatesEntity
     */
    public function setCurrentSaison(ConfigSaisonDates $currentSaison): SaisonDatesEntity
    {
        $this->currentSaison = $currentSaison;
        return $this;
    }

    /**
     * @return Period
     */
    public function getPeriod(): Period
    {
        return $this->period;
    }

    /**
     * @param Period $period
     * @return SaisonDatesEntity
     */
    public function setPeriod(Period $period): SaisonDatesEntity
    {
        $this->period = $period;
        return $this;
    }

    /**
     * @return array
     */
    public function getDailyPrices(): Collection
    {
        return collect($this->dailyPrices)->sortKeysDesc();
    }

    /**
     * @param array $dailyPrices
     * @return SaisonDatesEntity
     */
    public function addDailyPrices($date, $dailyPrice): SaisonDatesEntity
    {
        $this->dailyPrices[$date->format('Y-m-d')] = $dailyPrice;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     * @return SaisonDatesEntity
     */
    public function setPrice($price): SaisonDatesEntity
    {
        $this->price = $price;
        return $this;
    }


    public function __toString(): string
    {
        return $this->saison->name;
    }
}
