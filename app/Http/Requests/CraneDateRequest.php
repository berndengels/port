<?php

namespace App\Http\Requests;

class CraneDateRequest extends AdminRequest
{
    protected function prepareForValidation()
    {
        parent::prepareForValidation();
        $this->merge([
            'crane_date' => $this->crane_date .' ' . $this->crane_time,
        ]);
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
            'crane_date' => 'required',
            'crane_time' => 'required',
        ];
    }
}
