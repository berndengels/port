<?php

namespace App\Http\Requests;

use App\Models\BerthCategory;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBerthCategoryRequest extends FormRequest
{
    protected $modelName = BerthCategory::class;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->auth->user()->can('write BerthCategory');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'  =>  'required',
        ];
    }
}
