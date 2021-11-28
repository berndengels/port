<?php

namespace App\Http\Requests;

class DailyPriceRequest extends AdminRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'affordable_id'     => 'required',
            'affordable_type'   => 'required',
            'saison_date_id'    => 'required',
            'price_type_id'     => 'required',
            'day_price'         => 'required',
            'from_unit'         => '',
            'until_unit'        => '',
        ];
    }
}
