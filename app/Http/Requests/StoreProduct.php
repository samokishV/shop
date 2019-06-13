<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProduct extends FormRequest
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
            'category' => 'required | numeric',
            'slug' => ['required', 'alpha_dash', Rule::unique('products')],
            'image' => ['required', Rule::dimensions()->minWidth(400)->minHeight(400)],
            'image.*' => 'mimes:jpeg,png,jpg | max:2048',
            'title' => 'required',
            'description' => 'required',
            'price' => 'required | numeric',
            'in_stock' => 'required | numeric'
        ];
    }
}
