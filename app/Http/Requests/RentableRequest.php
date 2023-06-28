<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;

class RentableRequest extends AdminRequest
{
    protected $modelName = 'Rentable';
    protected $routeParam = 'rentable';
	protected $booleanFields = ['is_paid'];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return $this->auth->user()->can('write Rentable');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'rentable_type' => 'required',
            'rentable_id'   => 'required',
            'customer_id'   => 'required',
	        'from'          => ['exclude_if:until,null','required','date','before:until'],
            'until'         => ['required','date','after:from'],
            'price'         => '',
            'prices'        => '',
            'kilowatt'      => '',
            'kilowatt_value'  => '',
            'rental_cleaning' => '',
            'is_paid'       => '',
        ];
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
