<?php

namespace App\Http\Requests;

class ConfigOfferRequest extends AdminRequest
{
    protected $modelName = 'ConfigOffer';
	protected $booleanFields = ['enabled'];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return auth()->user()->can('write Offer');
    }

    /**
     * Get the validation rules that apply to the request.Customer
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name'      => 'required|min:3',
            'enabled'   => '',
        ];

        return $rules;
    }
}
