<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CaravanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    public function validationData()
    {
        return array_merge($this->all(), ['carlength' => (int) request()->carlength]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'carnumber' => !$this->id ? 'required|unique:caravans,carnumber' : 'required',
            'carlength' => 'required|digits_between:1,2',
        ];
    }
}
