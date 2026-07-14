<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // la ruta ya está protegida por el middleware auth
    }

    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:255'],
            'headline' => ['required', 'string', 'max:255'],
            'bio' => ['required', 'string', 'max:1000'],
            'about' => ['nullable', 'string', 'max:10000'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,webp', 'max:4096'],
            'remove_photo' => ['nullable', 'boolean'],
            'cv' => ['nullable', 'file', 'extensions:pdf', 'mimetypes:application/pdf', 'max:4096'],
            'remove_cv' => ['nullable', 'boolean'],
            'public_email' => ['nullable', 'email', 'max:255'],
            'github_url' => ['nullable', 'url:https', 'max:255'],
            'linkedin_url' => ['nullable', 'url:https', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'bio.max' => 'La presentación breve no puede superar los :max caracteres (para el texto largo usa el campo "Sobre mí").',
            'cv.extensions' => 'El CV debe ser un archivo .pdf.',
            'cv.mimetypes' => 'El CV debe ser un PDF real (el contenido no coincide con un PDF).',
            'cv.max' => 'El CV no puede superar los 4 MB.',
        ];
    }

    public function attributes(): array
    {
        return [
            'full_name' => 'nombre completo',
            'headline' => 'titular',
            'bio' => 'presentación breve',
            'about' => 'sobre mí',
            'photo' => 'foto',
            'cv' => 'CV',
            'public_email' => 'email público',
        ];
    }

    /**
     * Datos listos para persistir (los archivos se gestionan aparte).
     */
    public function profileData(): array
    {
        $data = $this->validated();

        unset($data['photo'], $data['remove_photo'], $data['cv'], $data['remove_cv']);

        return $data;
    }
}
