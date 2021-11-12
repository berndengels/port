<?php

namespace App\Traits\Models\Calculations;

use App\Libs\Calculations\Boat\Area;

trait BoatAreaCalculation
{
    public function getUnderwaterShipArea()
    {
        return (new Area(
            boatType: $this->boat_type,
            lengthWaterline: $this->length_waterline,
            lengthKeel: $this->length_keel,
            width: $this->width,
            draft: $this->draft
        ))->getArea();
    }
}
