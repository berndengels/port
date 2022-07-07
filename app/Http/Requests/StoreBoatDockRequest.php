<?php

namespace App\Http\Requests;

use App\Models\BoatDock;

class StoreBoatDockRequest extends AdminRequest
{
    protected $modelName = BoatDock::class;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->auth->user()->can('write BoatDock');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'name' => 'nullable|string|max:1|uniq:boat_docks:name',
            'length' => 'nullable|numeric',
            'min_box_length' => 'nullable|numeric',
            'max_box_length' => 'nullable|numeric',
        ];
    }
}
