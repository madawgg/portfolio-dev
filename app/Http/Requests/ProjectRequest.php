<?php

namespace App\Http\Requests;

use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // la ruta ya está protegida por el middleware auth
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'summary' => ['nullable', 'string', 'max:300'],
            'description' => ['required', 'string', 'max:6000'],
            'technologies' => ['nullable', 'string', 'max:255'],
            'category' => ['required', 'in:profesional,personal'],
            'company' => ['nullable', 'string', 'max:255'],
            'repo_url' => ['nullable', 'url:https', 'max:255'],
            'demo_url' => ['nullable', 'url:https', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,webp', 'max:4096'],
            'remove_thumbnail' => ['nullable', 'boolean'],
            'photos' => ['nullable', 'array', 'max:12'],
            'photos.*' => ['image', 'mimes:jpeg,png,webp', 'max:4096'],
        ];
    }

    public function messages(): array
    {
        return [
            'category.in' => 'La categoría debe ser profesional o personal.',
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'título',
            'summary' => 'descripción breve',
            'description' => 'descripción completa',
            'technologies' => 'tecnologías',
            'category' => 'categoría',
            'company' => 'empresa',
            'sort_order' => 'orden',
            'thumbnail' => 'miniatura',
            'photos' => 'fotos',
            'photos.*' => 'foto',
        ];
    }

    /**
     * Datos listos para persistir: un proyecto personal no lleva empresa.
     */
    public function projectData(): array
    {
        $data = $this->validated();

        if ($data['category'] === Project::CATEGORY_PERSONAL) {
            $data['company'] = null;
        }

        unset($data['remove_thumbnail'], $data['photos'], $data['thumbnail']);

        return $data;
    }
}
