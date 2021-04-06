<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'username' => 'required|string|alpha_dash|max:50|unique:users,username,' . $this->id,
            'first_name' => 'string|regex:/^[a-zA-Z]+$/u',
            'last_name' => 'string|regex:/^[a-zA-Z]+$/u',
            'email' => 'required|string|email|max:191|unique:users,email,' . $this->id,
            'password' => 'sometimes|string|min:6',
            'role' => 'required',
            'status' => 'required'
        ];
    }
}
