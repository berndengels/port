<?php

namespace App\Http\Requests;

class StorCraneDateRequest extends AdminRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
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
            'crane_date' => 'required|unique:boat_crane_dates,crane_date',
        ];
    }
}
