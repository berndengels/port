<?php

namespace App\Http\Requests;

class HouseboatRequest extends AdminRequest
{
    protected $modelName = 'Houseboat';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('write Houseboat');
    }

    /**
     * Get the validation rules that apply to the request.Customer
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name'          => 'required|min:3',
            'houseboat_model_id'   => 'required',
        ];

        return $rules;
    }
}
