<?php

namespace App\Http\Requests;

class StoreConfigHolidayRequest extends AdminRequest
{
    protected $modelName = ConfigHoliday::class;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return $this->auth->user()->can('write ConfigHoliday');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'key'   => 'required|unique:config_holidays,key',
            'name'   => 'required|unique:config_holidays,name',
            'enabled'   => '',
        ];
    }
}
