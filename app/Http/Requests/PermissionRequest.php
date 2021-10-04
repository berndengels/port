<?php
namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;

class PermissionRequest extends AdminRequest
{
    protected $modelName = 'Permission';

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
            'name' => !$this->getId() ? Rule::unique('permissions')->where(function(Builder $query) {
                return $query
                    ->whereName($this->name)
                    ->whereGuardName($this->guard_name)
                ;
            }) : '',
            'guard_name'    => 'required',
            'model'         => 'required',
            'action'        => 'required',
        ];
    }
}
