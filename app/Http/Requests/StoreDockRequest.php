<?php

namespace App\Http\Requests;

use App\Models\Dock;

class StoreDockRequest extends AdminRequest
{
    protected $modelName = Dock::class;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return $this->auth->user()->can('write Dock');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'name' => 'nullable|string|max:1|unique:docks,name',
            'length' => 'nullable|numeric',
            'min_box_length' => 'nullable|numeric',
            'max_box_length' => 'nullable|numeric',
        ];
    }
}
