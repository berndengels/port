<?php
namespace App\Http\Requests;

class MaterialRequest extends AdminRequest
{
    protected $modelName = 'Material';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->auth->user()->can('write Material');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'              => !$this->getId() ? 'required|unique:App\Models\Material,name' : 'required',
            'material_category_id' => 'required',
            'price_type_id'     => 'required',
//            'number'            => 'required',
            'price_per_unit'    => 'required',
            'fertility'         => '',
            'fertility_per'     => '',
            'fertility_unit'    => '',
        ];
    }
}
