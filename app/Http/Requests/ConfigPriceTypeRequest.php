<?php

namespace App\Http\Requests;

class ConfigPriceTypeRequest extends AdminRequest
{
    protected $modelName = 'ConfigPriceType';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return $this->auth->user()->can('write ConfigPriceType');
    }

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
