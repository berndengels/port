<?php

namespace App\Http\Requests;

use App\Models\House;

class UpdateHouseRequest extends AdminRequest
{
    protected $modelName = House::class;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return $this->auth->user()->can('write House');
    }

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
