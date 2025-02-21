<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Allow all users to access registration
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed', // 'confirmed' checks for 'password_confirmation'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Please enter your name.',
            // Additional custom messages...
        ];
    }
}