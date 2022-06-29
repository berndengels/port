<?php

namespace App\Http\Resources;

use App\Models\GuestBoatBerth;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GuestBoatBerthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request $request
     * @return array
     */
    public function toArray($request)
    {
        /**
         * @var GuestBoatBerth $this
         */
        return [
            'id'            => $this->id,
            'number'        => $this->number,
            'width'         => $this->width,
            'length'        => $this->length,
            'daily_price'   => $this->daily_price,
            'lat'           => $this->lat,
            'lng'           => $this->lng,
            'enabled'       => $this->enabled,
        ];
    }
}
