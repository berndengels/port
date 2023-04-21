<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MainFormRequest extends FormRequest
{
    protected $modelName;
    protected $routeParam;

    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
        if(!$this->routeParam) {
            $this->routeParam = lcfirst($this->modelName);
        }
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth('admin')->check();
    }

    protected function getId()
    {
        $route = $this->route($this->routeParam);
        if($route) {
            return $route->id;
        }
        return null;
    }

}
