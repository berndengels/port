<?php
namespace App\Http\Requests;

class ServiceRequestRequest extends MainFormRequest
{
    protected $modelName = 'ServiceRequest';
	protected $booleanFields = ['done'];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
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
                'done' => (bool) $this->post('done', false) ?? false,
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
            'boat_id'       => 'required',
            'description'   => 'required',
            'done_until'    => 'required|date',
            'done'          => '',
            'done_at'       => '',
            'services'      => [],
        ];
        return $rules;
    }
}
