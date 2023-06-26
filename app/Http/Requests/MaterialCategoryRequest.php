<?php
namespace App\Http\Requests;

class MaterialCategoryRequest extends AdminRequest
{
    protected $modelName = 'MaterialCategory';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return $this->auth->user()->can('write MaterialCategory');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => !$this->getId() ? 'required|unique:App\Models\MaterialCategory,name' : 'required',
            'modus' => 'required',
        ];
    }
}
