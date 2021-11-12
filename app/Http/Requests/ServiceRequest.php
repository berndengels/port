<?php
namespace App\Http\Requests;

class ServiceRequest extends AdminRequest
{
    protected $modelName = 'Service';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return ($this->auth->user()->can('write Service'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'  => !$this->getId() ? 'required|unique:App\Models\Service,description' : 'required',
            'service_category_id' => 'required',
            'price'         => 'required',
            'materials'     => [],
        ];
    }
}
