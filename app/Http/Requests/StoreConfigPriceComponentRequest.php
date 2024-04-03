<?php

namespace App\Http\Requests;

class StoreConfigPriceComponentRequest extends ConfigPriceComponentRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
		$rules = parent::rules();
		$rules['name']	= 'required|unique:config_price_components,name';
		$rules['key']	= 'required|unique:config_price_components,key';

		return $rules;
    }
}
