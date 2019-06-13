<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCategory extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'parent_category' => 'required',
            'category' => 'required | unique:"categories',
            'slug' => 'required | alpha_dash | unique:"categories',
            'image' => ['required',
                Rule::dimensions()->minWidth(400)->minHeight(400)
            ],
            'image.*' => 'mimes:jpeg,png,jpg | max:2048'
        ];
    }
}
