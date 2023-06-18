<?php
namespace App\Http\Requests;

class HouseboatRentalsRequest extends AdminRequest
{
    protected $modelName = 'HouseboatRentals';
    protected $routeParam = 'houseboatDate';
	protected $booleanFields = ['is_paid'];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->auth->user()->can('write HouseboatRentals');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'houseboat_id'  => 'required',
            'customer_id'   => '',
            'from'          => 'exclude_if:until,null|required|date|before:until',
            'until'         => ['required','date','after:from'],
            'price'         => '',
            'prices'        => '',
            'is_paid'       => '',
        ];
    }
}
