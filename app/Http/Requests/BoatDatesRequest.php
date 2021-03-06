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
            'from'          => 'exclude_if:until,null|date|before:until',
            'until'         => ['date','after:from'],
            'modus'         => '',
            'crane'         => '',
            'mast_crane'    => '',
            'cleaning'      => '',
            'is_paid'       => '',
        ];
    }
}
