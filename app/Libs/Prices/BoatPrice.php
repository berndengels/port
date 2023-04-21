<?php

namespace App\Libs\Prices;

use App\Libs\Prices\Boat\Base;
use App\Libs\Prices\Boat\Crane;
use App\Libs\Prices\Boat\MastCrane;
use App\Libs\Prices\Boat\Cleaning;
use App\Libs\Prices\Boat\Transport;
use Illuminate\Support\Collection;

class BoatPrice extends PriceCalculator
{
    /**
     * @var int
     */
    protected static $priceBase = 0;
    protected static $priceCrane = 0;
    protected static $priceMastCrane = 0;
    protected static $priceCleaning = 0;
    protected static $priceTransport = 0;

    public function params(): Collection
    {
        return collect([
            'crane',
            'mast_crane',
            'cleaning',
            'transport',
            'modus',
            'length',
            'width',
            'weight',
            'type',
            'board_height',
            'mast_length',
            'mast_weight',
            'draft',
            'length_waterline',
            'length_keel',
        ]);
    }

    protected function registerAddPriceClasses(): Collection
    {
        return collect([
            Base::class,
            Transport::class,
            Crane::class,
            MastCrane::class,
            Cleaning::class,
        ]);
    }
}
