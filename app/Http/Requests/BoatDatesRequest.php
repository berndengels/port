<?php

namespace App\Http\Requests;

class BoatDatesRequest extends AdminRequest
{
    protected $modelName = 'BoatDates';
    protected $routeParam = 'boatDate';
	protected $booleanFields = ['crane', 'mast_crane', 'cleaning', 'transport', 'is_paid'];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->auth->user()->can('write BoatDates');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'boat_id'       => 'required',
            'price'         => 'required',
            'prices'        => 'required',
            'modus'         => '',
            'from'          => 'exclude_if:modus,!null|exclude_if:until,null|date|before:until',
            'until'         => ['exclude_if:modus,!null','date','after:from'],
            'crane'         => '',
            'mast_crane'    => '',
			'duration_mast_crane'    => '',
            'cleaning'      => '',
			'duration_cleaning'    => '',
            'transport'     => '',
            'is_paid'       => '',
        ];
    }
}
