<?php

namespace App\Http\Requests;

use App\Models\Caravan;
use App\Models\CaravanDates;
use App\Rules\DatesIntervalUnique;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class CaravanDatesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    public function validationData()
    {
        return array_merge($this->all(), ['electric' => !!request()->post('electric') ?? false]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
/*
        $carnumber = request('carnumber');
        $carlength = request('carlength');
        $email     = request('email');
        $caravan = Caravan::whereCarnumber($carnumber)->first() ?? new Caravan();
        $caravan->carnumber = $carnumber;
        $caravan->carlength = $carlength;
        if($email) {
            $caravan->email = $email;
        }
        $caravan->save();
*/
        return [
            'carnumber' => 'required',
            'carlength' => ['required','regex:/^[1-9]+$/i'],
            'from'      => 'date',
            'until'     => 'date|after:from',
/*
            'until'     => [
                'date',
                !$this->id ? new DatesIntervalUnique($caravan) : null,
            ],
*/
            'email'     => 'email|nullable',
            'persons'   => ['required','regex:/^[1-9]+$/i'],
            'price'     => 'required|numeric',
            'caravan_id' => '',
            'electric'  => '',
            'prices'    => '',
        ];
    }

    public function messages()
    {
        return [
            'carnumber.required'    => 'Bitte das Auto-Kennzeichen angeben!',
            'carlength.required'    => 'Bitte die Länge des Fahrzeugs angeben!',
            'carlength.regex'       => 'Die Länge des Fahrzeugs muß als ganze Zahl angegeben werden!',
            'from.date'             => 'Das Anreise-Datum muß als Datum angegeben werden.',
            'until.date'            => 'Das Abreise-Datum muß als Datum angegeben werden.',
            'until.after'           => 'Das Anreise-Datum liegt vor einem vorhandenen Abreise-Datum',
            'persons.required'      => 'Bitte die Anzahl der Personen angeben.',
            'persons.regex'         => 'Die Anzahl der Personen muß eine ganza Zahl sein.',
            'price.required'        => 'Bitte einen Preis angeben.',
            'price.numeric'         => 'Der Preis muß eine ganze Zahl sein.',
            'email.email'           => 'Bitte eine korrekte oder keine Email-Adresse angeben.',
        ];
    }
}
