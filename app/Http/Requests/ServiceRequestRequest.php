<?php
namespace App\Http\Requests;

class ServiceRequestRequest extends MainFormRequest
{
    protected $modelName = 'ServiceRequest';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (
            ($this->user('admin') && $this->user('admin')->can('write ServiceRequest'))
            || ($this->user('customer') && $this->user('customer')->can('write ServiceRequest'))
        );
    }

    public function validationData()
    {
        return array_merge(
            $this->all(), [
                'done' => !!$this->post('done') ?? false,
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
        $rules = [
            'description'   => 'required',
            'done'          => '',
            'done_at'       => '',
            'services'      => [],
        ];
        if(auth('admin')->check()) {
            $rules += ['customer_id'   => 'required'];
        }
        return $rules;
    }
}
