<?php

namespace App\Http\Requests;


class BoatGuestRequest extends AdminRequest
{
    protected $modelName = 'BoatGuest';
    protected $routeParam = 'boatGuest';

    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        return $this->auth->user()->can('write BoatGuest');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'      => $this->getId() ? 'required' : 'required|unique:App\Models\BoatGuest,name',
            'length'    => 'required|numeric',
            'home_port' => '',
        ];
    }
}
