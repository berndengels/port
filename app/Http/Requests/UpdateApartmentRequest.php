<?php

namespace App\Http\Requests;

use App\Models\Apartment;

class UpdateApartmentRequest extends AdminRequest
{
    protected $modelName = Apartment::class;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->auth->user()->can('write Apartment');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'apartment_model_id'   => 'required',
            'name'              => 'required|min:3|unique:apartments,name',
            'calendar_color'    => '',
        ];
    }
}
