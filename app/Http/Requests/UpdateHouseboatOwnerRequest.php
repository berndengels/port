<?php

namespace App\Http\Requests;

use App\Models\HouseboatOwner;

class UpdateHouseboatOwnerRequest extends AdminRequest
{
    protected $modelName = HouseboatOwner::class;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return $this->auth->user()->can('write HouseboatOwner');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'      => 'required',
            'email'     => 'required|email',
            'city'      => 'required',
            'postcode'  => 'required',
            'street'    => 'required',
            'fon'       => 'required',
            'bank'      => 'required',
            'iban'      => 'required',
            'bic'       => 'required',
        ];
    }
}
