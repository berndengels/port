<?php

namespace App\Http\Requests;

class ConfigSaisonRentRequest extends AdminRequest
{
    protected $modelName = 'ConfigSaisonRent';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return auth()->user()->can('write ConfigSaisonRent');
    }

    /**
     * Get the validation rules that apply to the request.Customer
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'key'   => 'required',
            'name'  => 'required',
            'price' => '',
        ];
        return $rules;
    }
}
