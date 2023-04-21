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
    protected $boatPrices = [];
    protected $price;
    protected $fromMonth;
    protected $untilMonth;

    public function __construct(
        protected ConfigSaisonDates $saison,
        protected Carbon $from,
        protected Carbon $until
    )
    {
        $this->fromMonth = $this->from->month;
        $this->untilMonth = $this->until->month;
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
//        return collect($this->dailyPrices)->sortKeysDesc();
        return collect($this->dailyPrices)->sortKeys();
    }

    /**
     * @param array $dailyPrices
     * @return SaisonDatesEntity
     */
    public function addDailyPrices($date, $dailyPrice): SaisonDatesEntity
    {
        $this->dailyPrices[$date->format('Y-m-d')] = [
            'price'  => $dailyPrice,
            'saison' => $this->getSaisonName(),
        ];
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

    public function boatPrice()
    {
        return $this->saison->boatPrice();
    }

    public function dailyPrice()
    {
        return $this->saison->dailyPrice();
    }

    /**
     * @return array
     */
    public function getBoatPrices(): array
    {
        return $this->boatPrices;
    }

    /**
     * @return int
     */
    public function getFromMonth(): int
    {
        return $this->fromMonth;
    }

    /**
     * @return int
     */
    public function getUntilMonth(): int
    {
        return $this->untilMonth;
    }

    public function untilIsNextYear()
    {
        return $this->fromMonth > $this->untilMonth;
    }

    public function __toString(): string
    {
        return $this->saison->name;
    }
}
