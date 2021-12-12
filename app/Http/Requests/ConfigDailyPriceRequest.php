<?php

namespace App\Http\Requests;

class ConfigDailyPriceRequest extends AdminRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->auth->user()->can('write ConfigDailyPrice');
    }

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
