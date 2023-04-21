<?php

namespace App\Http\Requests;

use App\Models\ConfigSetting;

class StoreConfigSettingsRequest extends AdminRequest
{
    protected $modelName = ConfigSetting::class;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->auth->user()->can('write ConfigSettings');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'      =>  'required|unique:config_settings,name',
            'lat'       => '',
            'lng'       => '',
            'street'    => '',
            'location'  => '',
            'postcode'  => '',
            'email'     => 'nullable|email',
            'fon'       => '',
            'bank'      => '',
            'bic'       => ['nullable','regex:/^([a-zA-Z]){6}([0-9a-zA-Z]){2}([0-9a-zA-Z]{3})?$/'],
            'iban'      => ['nullable','regex:/^DE\d{2}[ ]\d{4}[ ]\d{4}[ ]\d{4}[ ]\d{4}[ ]\d{2}|DE\d{20}$/'],
            'tax'       => '',
            'use_tax'   => '',
        ];
    }
}
