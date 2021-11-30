<?php

namespace App\Http\Requests;

class ConfigBoatPriceRequest extends AdminRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'saison_date_id'    => 'required',
            'price_type_id'     => 'required',
            'price_factor'      => 'required',
        ];
    }
}
