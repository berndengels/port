<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    protected function getId()
    {
        $route = $this->route('role');
        if($route) {
            return $route->id;
        }
        return null;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('write Role');
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
