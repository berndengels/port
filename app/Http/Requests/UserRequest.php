<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    protected function getId()
    {
        $route = $this->route('user');
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
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'              => 'required|min:3',
            'email'             => $this->getId() ? 'required' : 'required|email|unique:App\Models\User,email',
            'password'          => !$this->getId() ? 'required' : '',
            'password_repeat'   => 'required_if:passord,null',
            'roles'             => [],
        ];
    }
}
