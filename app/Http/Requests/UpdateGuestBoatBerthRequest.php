<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGuestBoatBerthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function validationData($keys = null)
    {
        return array_merge($this->all($keys), [
            'enabled' => !!$this->post('enabled') ?? false,
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
            'number'  => 'required',
            'width'  => '',
            'length'  => '',
            'daily_price'  => '',
            'lat'  => '',
            'lng'  => '',
            'enabled'  => '',
        ];
    }
}
