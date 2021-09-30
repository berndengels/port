<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
{
    protected function getId()
    {
        $route = $this->route('permission');
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
