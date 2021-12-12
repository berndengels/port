<?php

namespace App\Http\Requests;

class ConfigEntityTypeRequest extends AdminRequest
{
    protected $modelName = 'ConfigEntityType';
    protected $routeParam = 'entityType';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->auth->user()->can('write ConfigEntityType');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'model' => 'required',
//            'unit_inclusive'  => '',
//            'unit_price'  => 'required',
        ];
    }
}
