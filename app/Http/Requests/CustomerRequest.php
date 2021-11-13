<?php
namespace App\Http\Requests;

use Illuminate\Support\Facades\Hash;

class CustomerRequest extends AdminRequest
{
    protected $modelName = 'Customer';

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

    public function validationData($keys = null)
    {
        return array_merge($this->all($keys), ['confirmed' => !!$this->post('confirmed') ?? false]);
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
        //            'password'          => !$this->getId() ? 'required|alpha_num|between:6,20|confirmed' : 'sometimes|required|alpha_num|between:6,20|confirmed',
            'password'          => !$this->getId() ? 'required|alpha_num|between:6,20|confirmed' : 'nullable|alpha_num|between:6,20|required_if:confirmed,null',
            'customer_type'     => '',
//            'customer_type'     => '',
            'fon'               => 'required',
            'city'              => 'required',
            'postcode'          => 'required',
            'street'            => 'required',
        ];

        if(app()->environment(['production'])) {
            $rules += ['captcha' => 'required|captcha'];
        }

        return $rules;
    }
}
