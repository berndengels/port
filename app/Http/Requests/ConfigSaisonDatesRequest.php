<?php

namespace App\Http\Requests;

use Carbon\Carbon;

class ConfigSaisonDatesRequest extends AdminRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return $this->auth->user()->can('write ConfigSaisonDates');
    }

    protected function prepareForValidation()
    {
        $from   = Carbon::create($this->from);
        $until  = Carbon::create($this->until);

        $this->merge([
            'from_day'      => $from->format('d'),
            'from_month'    => $from->format('m'),
            'until_day'     => $until->format('d'),
            'until_month'   => $until->format('m'),
        ]);
        return $this;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'          => $this->getId() ? 'required|unique:App\Models\SaisonDates,name' : 'required',
            'from'          => 'exclude_if:until,null|required|date|before:until',
            'until'         => ['required','date','after:from'],
            'from_day'      => 'required',
            'from_month'    => 'required',
            'until_day'     => 'required',
            'until_month'   => 'required',
        ];
    }
}
