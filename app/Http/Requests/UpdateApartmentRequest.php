<?php

namespace App\Http\Requests;

use App\Models\Apartment;

class UpdateApartmentRequest extends AdminRequest
{
    protected $modelName = Apartment::class;
	protected $permission = 'write Apartment';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'apartment_model_id'   => 'required',
            'name'              => 'required|min:3',
            'calendar_color'    => '',
        ];
    }
}
