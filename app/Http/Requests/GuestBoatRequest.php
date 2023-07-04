<?php

namespace App\Http\Requests;

class GuestBoatRequest extends AdminRequest
{
    protected $modelName = 'GuestBoat';
    protected $routeParam = 'guestBoat';
	protected $permission = 'write GuestBoat';
	protected $floats = [
		'length',
		'draft',
	];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'      => 'required',
            'length'    => 'required|numeric',
            'home_port' => '',
            'email'     => 'nullable|email',
			'weight'    => 'nullable|numeric',
			'draft'     => 'nullable|numeric',
			'type'      => '',
        ];
    }
}
