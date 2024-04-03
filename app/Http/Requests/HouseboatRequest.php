<?php

namespace App\Http\Requests;

class HouseboatRequest extends AdminRequest
{
    protected $modelName = 'Rentals';
	protected $permission = 'write Houseboat';

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
