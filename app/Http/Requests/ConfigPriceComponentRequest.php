<?php

namespace App\Http\Requests;

class ConfigPriceComponentRequest extends MainFormRequest
{
    protected $modelName = 'ConfigPriceComponent';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'config_entity_type_id' => 'required',
            'price_type_id'  => 'required',
            'config_service_id'  => '',
            'name'  => !$this->getId() ? 'required|unique:config_price_components,name' : 'required',
            'key'  => !$this->getId() ? 'required|unique:config_price_components,key' : 'required',
            'unit_inclusive'  => '',
            'unit_price'  => 'required',
        ];
    }
}
