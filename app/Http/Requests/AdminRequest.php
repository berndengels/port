<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
{
    protected $modelName;
    protected $routeParam;
    /**
     * @var Auth
     */
    protected $auth;

    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        $this->auth = auth('admin');
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
        if(!$this->routeParam) {
            $this->routeParam = lcfirst($this->modelName);
        }
    }

    protected function getId()
    {
        $route = $this->route($this->routeParam);
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
        return false;
    }
}
