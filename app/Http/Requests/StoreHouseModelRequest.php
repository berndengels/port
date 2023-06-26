<?php

namespace App\Http\Requests;

use App\Models\HouseModel;

class StoreHouseModelRequest extends AdminRequest
{
    protected $modelName = HouseModel::class;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return $this->auth->user()->can('write HouseModel');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'          => 'required|min:3|unique:house_models,name',
            'description'   => 'required',
            'space'         => 'required',
            'floors'        => 'required',
            'sleeping_places'   => 'required',
            'peak_season_price' => 'required',
            'mid_season_price'  => 'required',
            'low_season_price'  => 'required',
        ];
    }
}
