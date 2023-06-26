<?php
namespace App\Http\Requests;

use App\Http\Requests\Helper\Fix;

class CaravanRequest extends AdminRequest
{
    use Fix;
    protected $modelName = 'Caravan';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return $this->auth->user()->can('write Caravan');
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
        $rule = [
            'country_id' => 'required',
            'carnumber' => !$this->getId() ? 'required|unique:caravans,carnumber' : 'required',
            'carlength' => ['required','regex:/^[0-9]+$/i'],
            'email'     => 'email|nullable',
        ];
        return $rule;
    }

    public function messages()
    {
        return [
            'country_id.required'  => 'Bitte ein Herkunftsland angeben!',
            'carnumber.required'   => 'Bitte das Auto-Kennzeichen angeben!',
            'carnumber.unique'     => 'Ein Fahrzeug mit diesem Kennzeichen wurde bereits eingetragen!',
            'carlength.required'   => 'Bitte die Länge des Fahrzeugs angeben!',
            'carlength.regex'      => 'Die Länge des Fahrzeugs muß als ganze Zahl angegeben werden!',
            'email.email'          => 'Bitte eine korrekte oder gar keine keine Email-Adresse angeben.',
        ];
    }
}
