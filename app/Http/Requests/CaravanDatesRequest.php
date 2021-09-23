<?php

namespace App\Http\Requests;

use App\Http\Requests\Helper\Fix;
use App\Models\Caravan;
use App\Models\CaravanDates;
use App\Rules\DatesIntervalUnique;
use Illuminate\Foundation\Http\FormRequest;

class CaravanDatesRequest extends FormRequest
{
    use Fix;

    /**
     * @var Caravan
     */
    protected $caravan;

    public function prepareForValidation()
    {
        $this->merge([
            'carnumber' => $this->fixCarNumber($this->carnumber),
        ]);
        return $this;
    }

    public function validationData($keys = null)
    {
        return array_merge($this->all($keys), ['electric' => !!$this->post('electric') ?? false]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'country_id' => 'required',
            'carnumber' => 'required',
            'carlength' => ['required','regex:/^[0-9]+$/i'],
            'from'      => 'date',
            'until'     => ['date','after:from'],
            'email'     => 'email|nullable',
            'persons'   => ['required','regex:/^[1-9]+$/i'],
            'price'     => 'required|numeric',
            'caravan_id' => '',
            'electric'  => '',
            'prices'    => '',
        ];

        if(!$this->id) {
//            $rules['until'] += [new DatesIntervalUnique($this->caravan)];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'carnumber.required'    => 'Bitte das Auto-Kennzeichen angeben!',
            'carlength.required'    => 'Bitte die Länge des Fahrzeugs angeben!',
            'carlength.regex'       => 'Die Länge des Fahrzeugs muß als ganze Zahl angegeben werden!',
            'from.date'             => 'Das Anreise-Datum muß als Datum angegeben werden.',
            'until.date'            => 'Das Abreise-Datum muß als Datum angegeben werden.',
            'until.after'           => 'Das Abreise-Datum muß nach dem Anreise-Datum liegen',
            'persons.required'      => 'Bitte die Anzahl der Personen angeben.',
            'persons.regex'         => 'Die Anzahl der Personen muß eine ganza Zahl sein.',
            'price.required'        => 'Bitte einen Preis angeben.',
            'price.numeric'         => 'Der Preis muß eine ganze Zahl sein.',
            'email.email'           => 'Bitte eine korrekte oder keine Email-Adresse angeben.',
        ];
    }

    public function setCaravan(Caravan $caravan)
    {
        $this->caravan = $caravan;
        return $this;
    }
}
