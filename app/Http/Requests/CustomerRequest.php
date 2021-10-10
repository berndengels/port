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
        return $this->user()->id === $this->getId() || auth()->user()->can('write Customer');
    }

    /**
     * Get the validation rules that apply to the request.Customer
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'              => 'required|min:3',
            'email'             => $this->getId() ? '' : 'nullable|email|unique:customers,email',
//            'password'          => !$this->getId() ? 'required|alpha_num|between:6,20|confirmed' : 'sometimes|required|alpha_num|between:6,20|confirmed',
            'password'          => !$this->getId() ? 'required|alpha_num|between:6,20|confirmed' : 'nullable|alpha_num|between:6,20|required_if:confirmed,null',
            'customer_type'     => 'required',
            'fon'               => '',
            'street'            => '',
            'postcode'          => '',
            'city'              => '',
        ];
    }
}
