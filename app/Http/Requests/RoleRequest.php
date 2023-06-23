<?php
namespace App\Http\Requests;

class RoleRequest extends AdminRequest
{
    protected $modelName = 'Role';
//    protected $routeParam = 'roles';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return $this->auth->user()->can('write Role');
    }

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
