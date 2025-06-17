<?php

namespace App\Http\Requests;

class ConfigPriceComponentRequest extends AdminRequest
{
    protected $modelName = 'ConfigPriceComponent';
    protected $routeParam = 'priceComponent';
	protected $permission = 'write ConfigPriceComponent';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'  => 'required',
            'key'  => 'required',
            'price_type_id'  => 'required',
            'config_service_id'  => '',
			'config_unit_range_type_id' => 'nullable|required_with:unit_from',
			'unit_from'		=> 'nullable',
			'unit_until'	=> 'nullable',
            'unit_inclusive'  => '',
            'unit_price'  => 'required',
            'entities' => [],
//            'price_component_id' => 'required',
        ];
    }
}
