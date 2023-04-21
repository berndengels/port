<?php

namespace App\Http\Requests;

class StoreConfigEntityRequest extends AdminRequest
{
    protected $modelName = 'ConfigEntity';
    protected $routeParam = 'entity';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->auth->user()->can('write ConfigEntity');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'model' => 'required|unique:config_entities,model',
            'priceComponents'  => [],
        ];
    }
}
