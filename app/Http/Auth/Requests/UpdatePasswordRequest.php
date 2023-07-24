<?php

namespace App\Http\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdatePasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'password_old' => ['required', 'string', 'current_password:web'],
            'password' => ['required', 'string', 'confirmed', Password::default()],
            'password_confirmation' => ['required', 'string'],
        ];
    }
}
