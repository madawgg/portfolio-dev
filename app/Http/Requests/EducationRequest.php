<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EducationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // la ruta ya está protegida por el middleware auth
    }

    public function rules(): array
    {
        return [
            'degree' => ['required', 'string', 'max:255'],
            'institution' => ['required', 'string', 'max:255'],
            'start_year' => ['required', 'integer', 'min:1970', 'max:2100'],
            'end_year' => ['nullable', 'integer', 'min:1970', 'max:2100', 'gte:start_year'],
            'description' => ['nullable', 'string', 'max:3000'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
        ];
    }

    public function attributes(): array
    {
        return [
            'degree' => 'título',
            'institution' => 'centro',
            'start_year' => 'año de inicio',
            'end_year' => 'año de fin',
            'description' => 'descripción',
            'sort_order' => 'orden',
        ];
    }
}
