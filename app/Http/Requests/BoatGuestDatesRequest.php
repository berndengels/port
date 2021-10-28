<?php
namespace App\Http\Requests;

class BoatGuestDatesRequest extends AdminRequest
{
    protected $modelName = 'BoatGuestDates';
    protected $routeParam = 'boatGuestDate';

    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        return $this->auth->user()->can('write BoatGuestDates');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'          => 'required',
            'length'        => 'required|numeric',
            'from'          => 'exclude_if:until,null|required|date|before:until',
            'until'         => ['required','date','after:from'],
            'home_port'     => '',
            'day_price'     => '',
            'price'         => 'required',
            'prices'        => 'required',
        ];
    }
}
