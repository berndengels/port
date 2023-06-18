<?php

namespace App\Http\Resources;

use App\Models\Boat;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BoatResource extends JsonResource
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
         * @var $this Boat
         */
        return [
            'id'   		=> $this->id,
            'name'      => $this->name,
            'length'	=> $this->length,
			'weigth'	=> $this->weight,
            'owner'    	=> $this->customer->name,
			'fon'		=> $this->customer->fon,
        ];
    }
}
