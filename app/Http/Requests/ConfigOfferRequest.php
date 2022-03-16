<?php

namespace App\Http\Requests;

class ConfigOfferRequest extends AdminRequest
{
    protected $modelName = 'ConfigOffer';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('write Offer');
    }

    public function validationData($keys = null)
    {
        return array_merge($this->all($keys),
            [
                'enabled' => !!$this->post('enabled') ?? false,
            ]);
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
