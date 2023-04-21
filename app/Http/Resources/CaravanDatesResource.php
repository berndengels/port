<?php

namespace App\Http\Resources;

use App\Models\CaravanDates;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CaravanDatesResource extends JsonResource
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
         * @var $this CaravanDates
         */
        return [
            'kennzeichen'   => $this->caravan->carnumber,
            'laenge'        => $this->caravan->carlength,
            'von'           => $this->from->format('d.m.Y'),
            'bis'           => $this->until->format('d.m.Y'),
            'tage'          => $this->from->diffInDays($this->until),
            'personen'      => $this->persons,
            'strom'         => $this->electric ? 'Ja' : 'Nein',
            'preis'         => $this->price,
        ];
    }
}
