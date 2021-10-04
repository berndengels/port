<?php
namespace App\Http\Requests;

class RoleRequest extends AdminRequest
{
    protected $modelName = 'Role';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'              => !$this->getId() ? 'required|unique:App\Models\Role,name' : 'required',
            'guard_name'        => 'required',
            'permissions'       => [],
        ];
    }
}
