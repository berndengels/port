<?php
namespace App\Http\Requests;

use Illuminate\Http\Request;
use App\Http\Requests\Helper\Fix;

class CaravanDatesValidationData
{
    use Fix;

    private $request;

    public function __construct(Request $request){
        $request->merge([
            'carnumber' => $this->fixCarNumber($request->carnumber),
            'electric' => !!$request->post('electric') ?? false,
        ]);
        $this->request = $request;
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
            'from'      => 'exclude_if:until,null|required|date|before:until',
            'until'     => ['required','date','after:from'],
            'email'     => 'email|nullable',
            'persons'   => ['required','regex:/^[1-9]+$/i'],
            'day_price' => 'numeric|nullable',
            'price'     => 'required|numeric',
            'caravan_id' => '',
            'electric'  => '',
            'prices'    => '',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'carnumber.required'    => 'Bitte das Auto-Kennzeichen angeben!',
            'carlength.required'    => 'Bitte die Länge des Fahrzeugs angeben!',
            'carlength.regex'       => 'Die Länge des Fahrzeugs muß als ganze Zahl angegeben werden!',
            'from.date'             => 'Das Anreise-Datum muß als Datum angegeben werden.',
            'from.before'           => 'Das Anreise-Datum muß vor dem Abreise Datum liegen.',
            'until.date'            => 'Das Abreise-Datum muß als Datum angegeben werden.',
            'until.after'           => 'Das Anreise-Datum liegt vor einem vorhandenen Abreise-Datum',
            'persons.required'      => 'Bitte die Anzahl der Personen angeben.',
            'persons.regex'         => 'Die Anzahl der Personen muß eine ganza Zahl sein.',
            'day_price.numeric'     => 'Der Tages-Preis muß numerisch sein.',
            'price.required'        => 'Bitte einen Preis angeben.',
            'price.numeric'         => 'Der Preis muß eine ganze Zahl sein.',
            'email.email'           => 'Bitte eine korrekte oder keine Email-Adresse angeben.',
        ];
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }
}
