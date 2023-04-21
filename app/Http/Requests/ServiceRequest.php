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

    public function validationData()
    {
        return array_merge(
            $this->all(), [
                'quantity' => (bool) $this->post('quantity', false) ?? 1,
            ]
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'  => !$this->getId() ? 'required|unique:App\Models\Service,name' : 'required',
            'service_category_id' => 'required',
            'price_type_id' => 'required',
            'price'         => 'required',
            'quantity'      => '',
            'materials'     => [],
        ];
    }
}
