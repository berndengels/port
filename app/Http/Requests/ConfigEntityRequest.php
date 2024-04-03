<?php

namespace App\Http\Requests;

class ConfigEntityRequest extends AdminRequest
{
    protected $modelName = 'ConfigEntity';
    protected $routeParam = 'entity';
	protected $permission = 'write ConfigEntity';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'model' => 'required',
            'priceComponents'  => [],
        ];
    }
}
