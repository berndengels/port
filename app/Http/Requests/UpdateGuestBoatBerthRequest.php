<?php

namespace App\Http\Requests;

use App\Models\GuestBoatBerth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateGuestBoatBerthRequest extends AdminRequest
{
    protected $modelName = GuestBoatBerth::class;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->auth->user()->can('write GuestBoatBerth');
    }

    public function validationData($keys = null)
    {
        return array_merge($this->all($keys), [
            'enabled' => !!$this->post('enabled') ?? false,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'number'        => 'required',
            'boat_dock_id'  => '',
            'width'         => '',
            'length'        => '',
            'daily_price'   => '',
            'lat'           => '',
            'lng'           => '',
            'enabled'       => '',
        ];
    }
}
