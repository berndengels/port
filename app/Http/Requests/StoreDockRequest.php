<?php

namespace App\Http\Requests;

class StoreDockRequest extends DockRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
		$rules = parent::rules();
		$rules['name']	= 'nullable|string|max:1|unique:docks,name';

		return $rules;
    }
}
