<?php

namespace App\Http\Requests;

class ConfigDailyPriceRequest extends AdminRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'model'             => 'required',
            'saison_date_id'    => 'required',
            'price_type_id'     => 'required',
            'price'             => 'required',
            'from_unit'         => '',
            'until_unit'        => '',
        ];
    }
}
