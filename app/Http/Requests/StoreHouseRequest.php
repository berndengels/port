<?php

namespace App\Http\Requests;

class StoreHouseRequest extends HouseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
		$rules = parent::rules();
		$rules['name'] 	= 'required|min:3|unique:houses,name';

		return $rules;
    }
}
