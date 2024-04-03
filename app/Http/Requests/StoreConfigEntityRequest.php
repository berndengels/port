<?php

namespace App\Http\Requests;

class StoreConfigEntityRequest extends ConfigEntityRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
		$rules = parent::rules();
		$rules['model']	= 'required|unique:config_entities,model';

		return $rules;
    }
}
