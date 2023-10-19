<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'User email',
            'password' => 'Password',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'User email is required.',
            'password.required' => 'Password is required.',
        ];
    }
}
