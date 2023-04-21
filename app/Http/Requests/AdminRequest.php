<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;

class AdminRequest extends MainFormRequest
{
    /**
     * @var Auth
     */
    protected $auth;
    protected $errors;
    protected static $counter = 0;

    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        $this->auth = auth('admin');
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->auth->check();
    }

    protected function failedValidation(Validator $validator)
    {
        if(request()->isXmlHttpRequest() && request()->wantsJson()) {
            $this->errors = $validator->errors();
            die(json_encode(['errors' => $this->errors]));
        }
        parent::failedValidation($validator);
    }

}
