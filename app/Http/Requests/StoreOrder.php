<?php

namespace App\Http\Requests;

use App\Rules\Name;
use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrder extends FormRequest
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
            'name' => ['required', new Name],
            'email' => 'required | email',
            'phone' => ['required', new PhoneNumber],
            'address' => 'required'
        ];
    }
}
