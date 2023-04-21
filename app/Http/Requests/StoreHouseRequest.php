<?php

namespace App\Http\Requests;

use App\Models\House;

class StoreHouseRequest extends AdminRequest
{
    protected $modelName = House::class;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
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
            'name'              => 'required|min:3|unique:houses,name',
            'calendar_color'    => '',
        ];
    }
}
