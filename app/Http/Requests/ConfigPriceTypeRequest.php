<?php

namespace App\Http\Requests;

class ConfigPriceTypeRequest extends MainFormRequest
{
    protected $modelName = 'ConfigPriceType';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'  => !$this->getId() ? 'required|unique:config_price_types,name' : 'required',
            'type'  => 'required',
            'unit'  => 'required',
        ];
    }
}
