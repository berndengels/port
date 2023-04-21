<?php
declare(strict_types=1);

namespace App\Libs\Prices\Boat;

use App\Libs\Prices\Price;
use App\Libs\Prices\IPrice;

/**
 * MastCrane
 */
class MastCrane extends Main implements IPrice
{
    /**
     * @param bool $mast_crane
     * @param int|null $mast_weight
     * @param int|null $mast_length
     * @param int|null $hours
     */
    public function __construct(
        protected bool $mast_crane = false,
        protected ?int $mast_weight = null,
        protected ?int $mast_length = null
    ) {
        $this->initConfig();
    }

    /**
     * @return Price
     */
    public function addPrice(): Price
    {
        if(true === $this->mast_crane && $this->mast_weight && $this->mast_length) {
            try {
                $value = match($this->priceType) {
                    'ton' => $this->unitPrice * $this->mast_weight / 1000,
                    'kilogram' => $this->unitPrice * $this->mast_weight,
                    'length' => $this->unitPrice * $this->mast_length,
                    default => $this->unitPrice,
                };
                return new Price($value);
            } catch(\Exception $e) {
                return response()->json([
                    'error' => $e->getMessage(),
                    'value' => $value,
                ]);
            }
        }
        return new Price();
    }
}
