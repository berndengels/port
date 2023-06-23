<?php

namespace App\Http\Requests;

use App\Models\Customer;

class ProfileRequest extends MainFormRequest
{
    protected $modelName = Customer::class;
    protected $routeParam = 'profile';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return auth('customer')->user()->id === $this->getId() || auth('admin')->check();
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
            'email'             => $this->getId() ? '' : 'nullable|email|unique:customers,email',
            'password'          => !$this->getId() ? 'required|alpha_num|between:6,20|confirmed' : 'nullable|alpha_num|between:6,20|required_if:confirmed,null',
            'fon'               => 'required',
            'city'              => 'required',
            'postcode'          => 'required',
            'street'            => 'required',
        ];

        return $rules;
    }
}
