<?php

namespace App\Http\Requests;

class StoreCustomerBoatRequest extends MainFormRequest
{
    protected $modelName = 'Boat';
    private $floats = ['length','width','draft','length_waterline','length_keel'];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
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
            'name'         => 'required|unique:boats,name',
            'type'         => 'required',
            'length'            => 'nullable|numeric',
            'width'             => 'nullable|numeric',
            'weight'            => 'nullable|numeric',
            'mast_length'       => 'nullable|numeric',
            'mast_weight'       => 'nullable|numeric',
            'draft'             => 'nullable|numeric',
            'length_waterline'  => 'nullable|numeric',
            'length_keel'       => 'nullable|numeric',
        ];
    }
}
