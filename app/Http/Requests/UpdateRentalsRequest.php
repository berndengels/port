<?php

use App\Http\Requests\AdminRequest;

class UpdateRentalsRequest extends AdminRequest
{
    protected $modelName = 'Rentable';
    protected $routeParam = 'rentable';
	protected $booleanFields = ['is_paid'];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
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
            'customer_id'   => '',
            'from'          => 'exclude_if:until,null|required|date|before:until',
            'until'         => ['required','date','after:from'],
            'price'         => '',
            'prices'        => '',
            'rental_cleaning' => '',
            'is_paid'       => '',
        ];
    }
}
