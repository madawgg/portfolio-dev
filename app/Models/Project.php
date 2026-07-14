<?php

namespace App\Models;

use App\Services\ThumbnailService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    public const CATEGORY_PROFESSIONAL = 'profesional';
    public const CATEGORY_PERSONAL = 'personal';

    protected $fillable = [
        'title',
        'description',
        'technologies',
        'category',
        'company',
        'repo_url',
        'demo_url',
        'thumbnail',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProjectImage::class)->orderBy('sort_order')->orderBy('id');
    }

    public function thumbnailUrl(): ?string
    {
        // Única fuente del nombre del directorio: la constante del servicio
        return $this->thumbnail ? asset(ThumbnailService::DIRECTORY.'/'.$this->thumbnail) : null;
    }

    /** Tecnologías como array (se guardan separadas por comas). */
    public function technologyList(): array
    {
        return $this->technologies
            ? array_filter(array_map('trim', explode(',', $this->technologies)))
            : [];
    }
}
