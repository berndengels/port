<?php

namespace App\Http\Requests;

class StoreHouseboatRequest extends HouseboatRequest
{
    /**
     * Get the validation rules that apply to the request.Customer
     *
     * @return array
     */
    public function rules()
    {
		$rules = parent::rules();
        $rules['name'] = 'required|min:3|unique:houseboats,name';

        return $rules;
    }
}
