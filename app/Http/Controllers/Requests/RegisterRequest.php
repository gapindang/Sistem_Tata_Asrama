<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email',
            'password' => 'required|min:6|confirmed',
            'g-recaptcha-response' => 'required|captcha'
        ];
    }

    public function messages(): array
    {
        return [
            'g-recaptcha-response.required' => 'Captcha harus diisi.',
            'g-recaptcha-response.captcha' => 'Captcha tidak valid.'
        ];
    }
}
