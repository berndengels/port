<?php

namespace App\Traits\Models\Calculations;

use App\Models\Boat;

trait BoatAreaCalculation
{
    public function getUnderwaterShipArea()
    {
        /**
         * @var $this Boat
         */
        switch($this->boat_type) {
            case 'motor':
                // LWL * (B + Tg)
                return $this->length_waterline * ($this->width + $this->draft);
                break;
            case 'sail':
                $percentKeel = round($this->length_keel * 100 / $this->length_waterline);
                // Kurzkieler
                if($percentKeel < 50) {
                    // 0.5 * LWL * (B + Tg)
                    return 0.5 * $this->length_waterline * ($this->width + $this->draft);
                }
                // Langkieler
                else {
                    // 0.75 * LWL * (B + Tg)
                    return 0.75 * $this->length_waterline * ($this->width + $this->draft);
                }
                break;
        }

        return null;
    }
}
