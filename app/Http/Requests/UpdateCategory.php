<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategory extends FormRequest
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
            'category' => ['required', Rule::unique('categories')->ignore($this->id)],
            'slug' => ['required', 'alpha_dash', Rule::unique('categories')->ignore($this->id)],
            'image' => [Rule::dimensions()->minWidth(400)->minHeight(400)],
            'image.*' => 'mimes:jpeg,png,jpg | max:2048'
        ];
    }
}
