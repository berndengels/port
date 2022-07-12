<?php

namespace App\Http\Resources;

use App\Models\ConfigPort;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConfigPortResource extends JsonResource
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
         * @var ConfigPort $this
         */
        return [
            'name'      => $this->name,
            'street'    => $this->street,
            'location'  => $this->location,
            'postcode'  => $this->postcode,
            'fon'       => $this->fon,
            'email'     => $this->email,
            'lat'       => (float) $this->lat,
            'lng'       => (float) $this->lng,
        ];
    }
}
