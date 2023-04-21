<?php

namespace App\Http\Resources;

use App\Models\Berth;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BerthGeoJsonResource extends JsonResource
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
         * @var Berth $this
         */
        return [
            'type'  => 'Feature',
            'geometry'  => [
                'type' => 'Point',
                'coordinates' => [$this->lng, $this->lat],
            ],
            'properties' => [
                'id'            => $this->id,
                'dock_id'       => $this->dock_id,
                'dock'          => $this->dock ? $this->dock->name : null,
                'number'        => $this->number,
                'width'         => $this->width,
                'length'        => $this->length,
                'daily_price'   => $this->daily_price,
                'lat'           => $this->lat,
                'lng'           => $this->lng,
                'enabled'       => $this->enabled,
            ],
        ];
    }
}
