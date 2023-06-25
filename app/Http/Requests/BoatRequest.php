<?php

namespace App\Http\Requests;

class BoatRequest extends AdminRequest
{
    protected $modelName = 'Boat';
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
        return $this->auth->user()->can('write Boat');
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
            'name'     => 'required',
            'fon'      => '',
            'email'    => 'nullable|email',
            'state'    => '',
            'name'         => 'required',
            'type'         => 'required',
            'costomer_id'       => '',
            'berth_id'          => '',
            'length'            => 'nullable|numeric',
            'width'             => 'nullable|numeric',
            'weight'            => 'nullable|numeric',
            'board_height'      => 'nullable|numeric',
            'mast_length'       => 'nullable|numeric',
            'mast_weight'       => 'nullable|numeric',
            'draft'             => 'nullable|numeric',
            'length_waterline'  => 'nullable|numeric',
            'length_keel'       => 'nullable|numeric',
            'home_port'         => '',
			'image'				=> 'nullable|image',
        ];
    }
}
