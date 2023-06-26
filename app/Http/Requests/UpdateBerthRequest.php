<?php

namespace App\Http\Requests;

use App\Models\Berth;

class UpdateBerthRequest extends AdminRequest
{
    protected $modelName = Berth::class;
	protected $booleanFields = ['enabled'];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return $this->auth->user()->can('write Berth');
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
