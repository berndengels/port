<?php

namespace App\Http\Requests;

class ConfigSaisonRentDatesRequest extends AdminRequest
{
    protected $modelName = 'ConfigSaisonRentDates';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('write ConfigSaisonRentDates');
    }

    /**
     * Get the validation rules that apply to the request.Customer
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'config_saison_rent_id'  => 'required',
            'from'      => 'exclude_if:until,null|required|date|before:until',
            'until'     => ['required','date','after:from'],
            'name'      => 'nullable|max:50',
            'holiday'   => 'nullable|max:25',
        ];

        return $rules;
    }
}
