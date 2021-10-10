<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BoatRequest extends AdminRequest
{
    protected $modelName = 'Boat';
    private $floats = ['length','width','draft','length_waterline','length_keel'];

    protected function prepareForValidation()
    {
        foreach($this->floats as $item) {
            $this->$item = str_replace(',','.', $item);
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
            'name'     => 'required',
            'fon'      => '',
            'email'    => '',
            'state'    => 'required',
            'boat_name'         => 'required',
            'boat_type'         => 'required',
            'costomer_id'       => '',
            'length'            => 'nullable|numeric',
            'width'             => 'nullable|numeric',
            'draft'             => 'nullable|numeric',
            'length_waterline'  => 'nullable|numeric',
            'length_keel'       => 'nullable|numeric',
            'home_port'         => '',
        ];
    }
}
