<?php
namespace App\Libs\Prices;

class MainPriceItem
{
    protected $daysCount = 0;

    /**
     * @return int
     */
    public function getDaysCount(): int
    {
        return $this->daysCount;
    }

    /**
     * @param int $daysCount
     * @return MainPriceItem
     */
    public function setDaysCount(int $daysCount): MainPriceItem
    {
        $this->daysCount = $daysCount;
        return $this;
    }
}
