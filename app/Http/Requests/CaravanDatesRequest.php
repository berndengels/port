<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CaravanDatesRequest extends FormRequest
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
        return array_merge($this->all(), ['electric' => !!request()->post('electric') ?? false]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'carnumber' => 'required',
            'carlength' => 'required',
            'from'      => 'required',
            'until'     => 'required',
            'persons'   => 'required',
            'price'     => 'required',
            'caravan_id' => '',
            'electric'  => '',
            'prices'    => '',
        ];
    }
}
