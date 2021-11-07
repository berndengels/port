<?php
namespace App\Http\Requests;

class RegistrationRequest extends CustomerRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.Customer
     *
     * @return array
     */
    public function rules()
    {
        $rules = array_merge(parent::rules(), [
            'boat_type'         => 'required',
            'boat_name'         => 'required',
            'length'            => 'required',
            'width'             => 'required',
            'weight'            => 'required',
            'draft'             => 'required',
            'length_waterline'  => '',
            'mast_length'       => 'exclude_if:boat_type,motor|required',
            'mast_weight'       => 'exclude_if:boat_type,motor|required',
            'length_keel'       => 'exclude_if:boat_type,motor|required',
        ]);

        if(app()->environment(['production'])) {
            $rules += ['captcha' => 'required|captcha'];
        }

        return $rules;
    }
}
