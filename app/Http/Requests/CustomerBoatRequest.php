<?php

namespace App\Http\Requests;

class CustomerBoatRequest extends MainFormRequest
{
    protected $modelName = 'Boat';
    protected $floats = ['length','width','draft','length_waterline','length_keel','board_height','mast_length'];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return auth('customer')->user()->can('write Boat');
    }

    protected function prepareForValidation()
    {
        foreach($this->floats as $item) {
            $this->$item = str_replace(',', '.', $item);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'         => 'required',
            'type'         => 'required',
            'length'            => 'required|numeric',
            'width'             => 'required|numeric',
            'weight'            => 'required|numeric',
            'board_height'      => 'required|numeric',
            'mast_length'       => 'nullable|numeric',
            'mast_weight'       => 'nullable|numeric',
            'draft'             => 'required|numeric',
            'length_waterline'  => 'required|numeric',
            'length_keel'       => 'nullable|numeric',
        ];
    }
}
