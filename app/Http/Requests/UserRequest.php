<?php
namespace App\Http\Requests;

class UserRequest extends AdminRequest
{
    protected $modelName = 'User';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->id === $this->getId() || auth()->user()->can('write User');
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
