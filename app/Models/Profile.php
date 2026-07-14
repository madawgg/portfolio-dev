<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'full_name',
        'headline',
        'bio',
        'about',
        'photo',
        'cv_filename',
        'public_email',
        'github_url',
        'linkedin_url',
    ];

    public function photoUrl(): ?string
    {
        return $this->photo
            ? asset(\App\Services\ThumbnailService::PHOTO_DIRECTORY.'/'.$this->photo)
            : null;
    }

    public function hasCv(): bool
    {
        return (bool) $this->cv_filename;
    }

    /**
     * Texto de la página "Sobre mí": el largo si existe; si no, la bio breve.
     */
    public function aboutText(): string
    {
        return $this->about ?: $this->bio;
    }

    /**
     * El perfil es un singleton: siempre trabajamos con el primer registro.
     * once() memoiza el resultado durante la petición (el layout y el
     * controlador lo piden por separado; así solo hay una consulta).
     */
    public static function current(): self
    {
        return once(fn () => static::firstOrCreate([], [
            'full_name' => 'Tu nombre',
            'headline' => 'Desarrollador web',
            'bio' => 'Edita tu biografía desde el panel de administración.',
        ]));
    }
}
