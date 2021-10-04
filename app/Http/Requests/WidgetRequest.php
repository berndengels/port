<?php
namespace App\Http\Requests;

class WidgetRequest extends AdminRequest
{
    protected $modelName = 'Widget';
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
            'position'  => $this->getId() ? '' : '',
            'slug'      => '',
        ];
    }
}
