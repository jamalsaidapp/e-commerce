<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'username' => 'required|string|alpha_dash|max:50|unique:users',
            'first_name' => 'string|regex:/^[a-zA-Z]+$/u',
            'last_name' => 'string|regex:/^[a-zA-Z]+$/u',
            'email' => 'required|string|email|max:50|unique:users',
            'password' => 'required|string|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' =>'The name field is required'
        ];
    }
}
