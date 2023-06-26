<?php

namespace App\Http\Resources;

use App\Models\Boat;
use App\Models\GuestBoat;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GuestBoatResource extends JsonResource
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
         * @var $this GuestBoat
         */
        return [
            'id'   		=> $this->id,
            'name'      => $this->name,
            'length'	=> $this->length,
            'owner'    	=> null,
			'weigth'	=> null,
			'fon'		=> null,
        ];
    }
}
