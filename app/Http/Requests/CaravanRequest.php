<?php

namespace App\Http\Requests;

use App\Http\Requests\Helper\Fix;
use Illuminate\Foundation\Http\FormRequest;

class CaravanRequest extends FormRequest
{
    use Fix;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    public function prepareForValidation()
    {
        $this->merge([
            'carnumber' => $this->fixCarNumber($this->carnumber),
        ]);
    }

    public function validationData()
    {
        return array_merge($this->all(), ['carlength' => (int) request()->carlength]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'country_id' => 'required',
            'carnumber' => !$this->id ? 'required|unique:caravans,carnumber' : 'required',
            'carlength' => ['required','regex:/^[0-9]+$/i'],
            'email'     => 'email|nullable',
        ];
    }

    public function messages()
    {
        return [
            'country_id.required'  => 'Bitte ein Herkunftsland angeben!',
            'carnumber.required'   => 'Bitte das Auto-Kennzeichen angeben!',
            'carlength.required'   => 'Bitte die Länge des Fahrzeugs angeben!',
            'carlength.regex'      => 'Die Länge des Fahrzeugs muß als ganze Zahl angegeben werden!',
            'email.email'          => 'Bitte eine korrekte oder gar keine keine Email-Adresse angeben.',
        ];
    }
}
