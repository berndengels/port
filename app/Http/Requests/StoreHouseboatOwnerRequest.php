<?php

namespace App\Http\Requests;

use App\Models\HouseboatOwner;

class StoreHouseboatOwnerRequest extends AdminRequest
{
    protected $modelName = HouseboatOwner::class;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
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
            'name'      => 'required|unique:houseboat_owners,name',
            'email'     => 'required|email|unique:houseboat_owners,email',
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
