<?php

namespace App\Http\Requests;

use App\Models\ConfigPort;

class StoreConfigPortRequest extends AdminRequest
{
    protected $modelName = ConfigPort::class;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->auth->user()->can('write ConfigPort');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'      =>  'required|unique:config_port,name',
            'lat'       => '',
            'lng'       => '',
            'street'    => '',
            'location'  => '',
            'postcode'  => '',
            'email'     => 'nullable|email',
            'phone'     => '',
        ];
    }
}
