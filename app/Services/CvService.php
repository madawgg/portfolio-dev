<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 * Gestiona el CV en PDF. Se guarda en el disco "local"
 * (storage/app/private/cv), fuera de la raíz web: solo se puede
 * descargar a través del controlador, nunca por URL directa.
 */
class CvService
{
    public const DIRECTORY = 'cv';

    /**
     * Valida el contenido real del PDF y lo guarda con nombre aleatorio.
     * Devuelve el nombre de archivo generado.
     */
    public function store(UploadedFile $file): string
    {
        // Defensa en profundidad: además del MIME (finfo, ya validado en el
        // controlador), comprobamos la firma del formato. Todo PDF empieza
        // por "%PDF-"; un ejecutable o script renombrado no pasa de aquí.
        $handle = fopen($file->getRealPath(), 'rb');
        $magic = fread($handle, 5);
        fclose($handle);

        if ($magic !== '%PDF-') {
            throw ValidationException::withMessages([
                'cv' => 'El archivo no es un PDF válido.',
            ]);
        }

        $filename = Str::uuid().'.pdf';

        Storage::disk('local')->putFileAs(self::DIRECTORY, $file, $filename);

        return $filename;
    }

    public function delete(?string $filename): void
    {
        if (! $filename) {
            return;
        }

        // basename() evita path traversal si la BD se viera comprometida
        Storage::disk('local')->delete(self::DIRECTORY.'/'.basename($filename));
    }

    public function path(string $filename): ?string
    {
        $relative = self::DIRECTORY.'/'.basename($filename);

        return Storage::disk('local')->exists($relative)
            ? Storage::disk('local')->path($relative)
            : null;
    }
}
