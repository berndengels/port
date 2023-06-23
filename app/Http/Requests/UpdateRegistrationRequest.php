<?php

namespace App\Http\Requests;

class UpdateRegistrationRequest extends CustomerRequest
{
    protected $floats = [
        'length',
        'width',
        'draft',
        'length_waterline',
        'length_keel',
        'board_height',
    ];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        foreach($this->floats as $item) {
            if(isset($this->$item)) {
                $this->$item = str_replace(',', '.', $item);
            }
        }
    }

    /**
     * Get the validation rules that apply to the request.Customer
     *
     * @return array
     */
    public function rules()
    {
        $rules = array_merge(parent::rules(), [
/*
            'type'         => 'required',
            'name'         => 'required|unique:boats,name',
            'length'            => 'required',
            'width'             => 'required',
            'weight'            => 'required',
            'board_height'      => 'nullable|numeric',
            'draft'             => 'required',
            'length_waterline'  => '',
            'mast_length'       => 'exclude_if:type,motor|required',
            'mast_weight'       => 'exclude_if:type,motor|required',
            'length_keel'       => 'exclude_if:type,motor|required',
            'captcha'           => 'required|captcha',
*/
        ]);

        return $rules;
    }
}
