<?php

namespace App\Http\Requests;

use App\Models\Berth;

class UpdateBerthRequest extends AdminRequest
{
    protected $modelName = Berth::class;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->auth->user()->can('write Berth');
    }

    public function validationData($keys = null)
    {
        return array_merge($this->all($keys), [
            'enabled' => !!$this->post('enabled') ?? false,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'number'        => 'required',
            'dock_id'       => 'required',
            'width'         => '',
            'length'        => '',
            'daily_price'   => '',
            'lat'           => '',
            'lng'           => '',
            'enabled'       => '',
        ];
    }
}
