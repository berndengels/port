<?php
namespace App\Http\Requests;

class PageRequest extends AdminRequest
{
    protected $modelName = 'Page';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return $this->auth->user()->can('write Page');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'     => $this->getId() ? 'required' : 'required|unique:pages,title',
            'content'   => 'required',
            'slug'      => '',
        ];
    }
}
