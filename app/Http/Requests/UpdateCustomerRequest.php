<?php

namespace App\Http\Requests;

class UpdateCustomerRequest extends AdminRequest
{
    protected $modelName = 'Customer';
	protected $booleanFields = ['confirmed', 'confirmed_old'];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return ($this->user('customer') && $this->user('customer')->id === $this->getId())
            || auth()->user()->can('write Customer');
    }

    /**
     * Get the validation rules that apply to the request.Customer
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name'              => 'required|min:3',
            'email'             => 'required|email',
            'password'          => 'nullable|alpha_num|between:6,20|required_if:confirmed,null',
            'type'     => '',
            'fon'               => 'required',
            'city'              => 'required',
            'postcode'          => 'required',
            'street'            => 'required',
            'confirmed'         => '',
            'confirmed_old'     => '',
            'roles'             => [],
        ];

        return $rules;
    }
}
