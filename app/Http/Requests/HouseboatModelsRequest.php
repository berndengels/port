<?php

namespace App\Http\Requests;

class HouseboatModelsRequest extends AdminRequest
{
    protected $modelName = 'HouseboatModel';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('write HouseboatModel');
    }

    /**
     * Get the validation rules that apply to the request.Customer
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name'          => 'required|min:3',
            'description'   => 'required',
            'space'         => 'required',
            'floors'        => 'required',
            'sleeping_places'   => 'required',
            'peak_season_price' => 'required',
            'mid_season_price'  => 'required',
            'low_season_price'  => 'required',
        ];

        return $rules;
    }
}
