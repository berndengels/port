<?php

namespace App\Http\Requests;

use App\Models\Dock;

class DockRequest extends AdminRequest
{
    protected $modelName = Dock::class;
	protected $permission = 'write Dock';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'name' => 'nullable|string|max:1',
            'length' => 'nullable|numeric',
            'min_box_length' => 'nullable|numeric',
            'max_box_length' => 'nullable|numeric',
        ];
    }
}
