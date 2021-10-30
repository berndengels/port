<?php
namespace App\Http\Requests;

class AdminUserRequest extends AdminRequest
{
    protected $modelName = 'AdminUser';
    protected $routeParam = 'user';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (($this->user() && $this->user()->id === $this->getId()) || (auth()->user() && auth()->user()->can('write User')));
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
            'email'             => $this->getId() ? 'required' : 'required|email|unique:App\Models\AdminUser,email',
            'password'          => !$this->getId() ? 'required' : '',
            'password_repeat'   => 'required_if:passord,null',
            'roles'             => [],
        ];
    }
}
