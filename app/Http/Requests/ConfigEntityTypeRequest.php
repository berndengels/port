<?php

namespace App\Http\Requests;

class ConfigEntityTypeRequest extends MainFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'model' => 'required',
            'priceComponents' => [],
        ];
    }
}
