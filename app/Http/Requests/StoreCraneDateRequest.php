<?php

namespace App\Http\Requests;

class StoreCraneDateRequest extends CraneDateRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules['date'] = 'required|unique:crane_dates,date';
        return $rules;
    }
}
