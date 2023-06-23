<?php

namespace App\Http\Requests;

class ConfigPriceComponentRequest extends AdminRequest
{
    protected $modelName = 'ConfigPriceComponent';
    protected $routeParam = 'priceComponent';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return $this->auth->user()->can('write ConfigPriceComponent');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
//            'name'  => !$this->getId() ? 'required|unique:config_price_components,name' : 'required',
//            'key'  => !$this->getId() ? 'required|unique:config_price_components,key' : 'required',
            'name'  => !$this->getId() ? 'required|unique:config_price_components,name' : 'required',
            'key'  => 'required',
            'price_type_id'  => 'required',
            'config_service_id'  => '',
            'unit_inclusive'  => '',
            'unit_price'  => 'required',
            'entities' => [],
//            'price_component_id' => 'required',
        ];
    }
}
