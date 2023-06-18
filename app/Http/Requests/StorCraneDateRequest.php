<?php

namespace App\Http\Requests;

class StorCraneDateRequest extends CraneDateRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules['crane_date'] = 'required|unique:crane_dates,crane_date';
        return $rules;
    }
}
