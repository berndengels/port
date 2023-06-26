<?php
namespace App\Http\Requests;

use Illuminate\Http\Request;
use App\Http\Requests\Helper\Fix;

class CaravanDatesValidationData
{
    use Fix;

    private $request;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return $this->auth->user()->can('write CaravanDates');
    }

    public function __construct(Request $request)
    {
        $request->merge([
            'carnumber' => $this->fixCarNumber($request->carnumber),
            'electric'  => !!$request->post('electric') ?? false,
            'is_paid'   => !!$request->post('is_paid') ?? false,
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
            'from'      => 'exclude_if:until,null|required|date',
            'until'     => ['required','date','after:from'],
            'email'     => 'email|nullable',
            'persons'   => ['required','regex:/^[1-9]+$/i'],
            'price'     => 'required|numeric',
            'caravan_id' => '',
            'electric'   => '',
            'prices'    => '',
            'is_paid'   => '',
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
            'until.date'            => 'Das Abreise-Datum muß als Datum angegeben werden.',
            'until.after'           => 'Das Abreise-Datum muß nach dem Anreise-Datum liegen',
            'persons.required'      => 'Bitte die Anzahl der Personen angeben.',
            'persons.regex'         => 'Die Anzahl der Personen muß eine ganza Zahl sein.',
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
