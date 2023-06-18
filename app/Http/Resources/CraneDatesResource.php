<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;
use App\Models\CraneDate;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CraneDatesResource extends JsonResource
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
         * @var $this CraneDate
         */
        $relation = class_basename($this->cranable);

        return [
            'title'     => $this->cranable->name,
            'allDay'    => false,
			'start'     => $this->crane_date,
            'extendedProps' => [
				'id'        => $this->cranable->id,
				'start'     => $this->crane_date,
				'name'      => $this->cranable->name,
                'type'   	=> $this->cranable->type,
                'customer'  => $this->cranable->customer ? $this->cranable->customer->name : null,
				'fon'		=> $this->cranable->customer ? $this->cranable->customer->fon : null,
                'relation'  => $relation
            ]
        ];
    }
}
