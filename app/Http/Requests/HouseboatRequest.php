<?php

namespace App\Http\Requests;

class HouseboatRequest extends AdminRequest
{
    protected $modelName = 'Rentals';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return auth()->user()->can('write Rentals');
    }

    /**
     * Get the validation rules that apply to the request.Customer
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'houseboat_model_id'   => 'required',
            'houseboat_owner_id'   => '',
            'name'              => 'required|min:3',
            'calendar_color'    => '',
        ];

        return $rules;
    }
}
