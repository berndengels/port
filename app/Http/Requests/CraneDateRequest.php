<?php

namespace App\Http\Requests;

class CraneDateRequest extends AdminRequest
{
	protected $permission = 'write CraneDate';
	protected $booleanFields = ['notify'];
	protected function prepareForValidation()
	{
		parent::prepareForValidation();
		$this->merge(['date' => $this->crane_date . ' ' . $this->crane_time]);
	}


	/**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cranable_type' => 'required',
            'cranable_id' => 'required',
			'date' => '',
            'crane_date' => 'required:date',
            'crane_time' => 'required',
			'notify'	=> '',
        ];
    }
}
