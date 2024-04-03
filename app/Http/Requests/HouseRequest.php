<?php

namespace App\Http\Requests;

use App\Models\House;

class HouseRequest extends AdminRequest
{
    protected $modelName = House::class;
	protected $permission = 'write House';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'house_model_id'   => 'required',
            'house_owner_id'   => '',
            'name'              => 'required|min:3',
            'calendar_color'    => '',
        ];
    }
}
