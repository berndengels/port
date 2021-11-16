<?php
namespace App\Http\Requests;

class ServiceCategoryRequest extends AdminRequest
{
    protected $modelName = 'ServiceCategory';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->auth->user()->can('write ServiceCategory');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => !$this->getId() ? 'required|unique:App\Models\ServiceCategory,name' : 'required',
            'modus' => 'required',
        ];
    }
}
