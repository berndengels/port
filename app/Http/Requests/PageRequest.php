<?php
namespace App\Http\Requests;

class PageRequest extends AdminRequest
{
    protected $modelName = 'Page';

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
