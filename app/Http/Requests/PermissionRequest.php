<?php
namespace App\Http\Requests;

class PermissionRequest extends AdminRequest
{
    protected $routeParam = 'permission';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('write Permission');
    }

    public function validationData()
    {
        return $this->merge([
            'name' => $this->name ?? $this->action . ' ' . $this->model,
        ])->toArray();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'          => !$this->getId() ? 'unique:App\Models\Permission,name' : '',
            'guard_name'    => 'required',
            'model'         => 'required',
            'action'        => 'required',
        ];
    }
}
