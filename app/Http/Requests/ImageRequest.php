<?php

namespace App\Http\Requests;

class ImageRequest extends AdminRequest
{

    protected $permissions = 'ImageUpload';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image' => 'nullable|image',
			'media_type' => '',
			'media_id' => '',
        ];
    }
}
