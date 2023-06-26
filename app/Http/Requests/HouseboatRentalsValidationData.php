<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;

class HouseboatRentalsValidationData
{
    public function __construct(private Request $request)
    {
        $this->authorize();
        $this->request->merge([
            'is_paid'   => !!$this->request->post('is_paid') ?? false,
        ]);
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        if(!$this->auth->user()->can('write HouseboatRentals')) {
            return redirect()->back()->with('error', 'Keine Berechtigung für diese Aktion!');
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'houseboat_id'  => 'required',
            'customer_id'   => '',
            'from'          => 'exclude_if:until,null|required|date|before:until',
            'until'         => ['required','date','after:from'],
            'price'         => '',
            'prices'        => '',
            'is_paid'       => '',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'from.date'             => 'Das Anreise-Datum muß als Datum angegeben werden.',
            'until.date'            => 'Das Abreise-Datum muß als Datum angegeben werden.',
            'until.after'           => 'Das Abreise-Datum muß nach dem Anreise-Datum liegen',
            'price.required'        => 'Bitte einen Preis angeben.',
            'price.numeric'         => 'Der Preis muß eine ganze Zahl sein.',
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
