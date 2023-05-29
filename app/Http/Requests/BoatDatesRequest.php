<?php

namespace App\Http\Requests;

class BoatDatesRequest extends AdminRequest
{
    protected $modelName = 'BoatDates';
    protected $routeParam = 'boatDate';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->auth->user()->can('write BoatDates');
    }

    public function validationData()
    {
        return array_merge(
            $this->all(), [
                'crane'         => !!$this->post('crane') ?? false,
                'mast_crane'    => !!$this->post('mast_crane') ?? false,
                'cleaning'      => !!$this->post('cleaning') ?? false,
                'transport'     => !!$this->post('transport') ?? false,
                'is_paid'       => !!$this->post('is_paid') ?? false,
            ]
        );
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
