<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
{
    protected $routeParam;

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
        return auth()->check();
    }
}
