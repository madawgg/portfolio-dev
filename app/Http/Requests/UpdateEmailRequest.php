<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmailRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // la ruta ya está protegida por el middleware auth
    }

    public function rules(): array
    {
        return [
            'email' => [
                'required', 'string', 'email:rfc', 'max:255',
                Rule::unique('users', 'email')->ignore($this->user()->id),
            ],
            'current_password' => ['required', 'current_password'],
        ];
    }

    public function attributes(): array
    {
        return [
            'email' => 'nuevo email',
            'current_password' => 'contraseña actual',
        ];
    }
}
