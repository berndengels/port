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
    public function authorize() : bool
    {
        return (($this->user() && $this->user()->id === $this->getId()) || (auth()->user() && auth()->user()->can('write User')));
    }

    protected function prepareForValidation()
    {
        $this->fon = preg_replace('/[ \t]+/i','', $this->fon);
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
            'fon'               => $this->getId() ? '' : 'sometimes|unique:App\Models\AdminUser,fon',
            'password'          => !$this->getId() ? 'required' : '',
            'password_repeat'   => 'required_if:passord,null',
            'roles'             => [],
        ];
    }
}
