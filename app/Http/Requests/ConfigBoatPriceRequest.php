<?php

namespace App\Http\Requests;

class ConfigBoatPriceRequest extends AdminRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return $this->auth->user()->can('write ConfigBoatPrice');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'              => 'required',
            'saison_date_id'    => 'required',
            'price_type_id'     => 'required',
            'price_factor'      => 'required',
        ];
    }
}
