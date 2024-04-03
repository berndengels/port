<?php

namespace App\Libs\Prices\Rentals;

use App\Libs\Prices\Boat\Main;
use App\Libs\Prices\IPrice;
use App\Libs\Prices\Price;
use Exception;
use Illuminate\Database\Eloquent\Model;

class RentalCleaning extends Main implements IPrice
{
    public function __construct(
		protected bool $rental_cleaning = true,
        protected Model $rentable
    ) {
        $this->model = get_class($this->rentable);
        parent::__construct();
        $this->initConfig();
    }

    public function addPrice(): Price
    {
		if($this->rental_cleaning) {
			try {
				$value = match($this->priceType) {
					'area' => $this->unitPrice * $this->rentable->model->space,
					default => $this->unitPrice,
				};
//			$value = $this->unitPrice * $this->rentable->model->space;
				return new Price($value);
			} catch(Exception $e) {
				return response()->json([
					'error' => $e->getMessage(),
					'value' => $value,
				]);
			}
		}

        return new Price(0);
    }
}
