<?php
namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;

class PermissionRequest extends AdminRequest
{
    protected $modelName = 'Permission';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return $this->auth->user()->can('write Permission');
    }

    public function validationData()
    {
        return $this->merge(
            ['name' => $this->name ?? $this->action . ' ' . $this->model]
        )->toArray();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => !$this->getId() ? Rule::unique('permissions')->where(
                function (Builder $query) {
                    return $query
                        ->whereName($this->name)
                        ->whereGuardName($this->guard_name);
                }
            ) : '',
            'custom_name'   => 'nullable|unique:permissions,name',
            'guard_name'    => 'required',
            'model'         => '',
            'action'        => 'required',
        ];
    }
}
