<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 * Guarda imágenes subidas (miniaturas de proyectos, foto de perfil...)
 * convertidas siempre a WebP y redimensionadas.
 */
class ThumbnailService
{
    public const DIRECTORY = 'project-mini-img';
    public const PHOTO_DIRECTORY = 'img';
    public const GALLERY_DIRECTORY = 'project-img';

    private const MAX_WIDTH = 900;
    private const WEBP_QUALITY = 82;

    /**
     * Tope de píxeles (ancho × alto) antes de decodificar. Un PNG de 4 MB
     * puede expandirse a gigabytes en memoria al decodificarlo (bomba de
     * descompresión); 25 MP cubre de sobra cualquier captura real.
     */
    private const MAX_PIXELS = 25_000_000;

    /**
     * Convierte la imagen subida a WebP y devuelve el nombre de archivo generado.
     */
    public function store(UploadedFile $file, string $directory = self::DIRECTORY, int $maxWidth = self::MAX_WIDTH): string
    {
        $contents = (string) file_get_contents($file->getRealPath());

        // Dimensiones leídas de la cabecera (sin decodificar): corta las
        // bombas de descompresión antes de que consuman memoria.
        $info = @getimagesizefromstring($contents);

        if ($info === false || ($info[0] * $info[1]) > self::MAX_PIXELS) {
            throw ValidationException::withMessages([
                'thumbnail' => $info === false
                    ? 'El archivo no es una imagen válida.'
                    : 'La imagen es demasiado grande (máximo 25 megapíxeles).',
            ]);
        }

        // Decodifica desde los bytes reales, no desde la extensión: un archivo
        // renombrado que no sea una imagen válida falla aquí.
        $image = @imagecreatefromstring($contents);

        if ($image === false) {
            throw ValidationException::withMessages([
                'thumbnail' => 'El archivo no es una imagen válida.',
            ]);
        }

        imagepalettetotruecolor($image);

        if (imagesx($image) > $maxWidth) {
            $resized = imagescale($image, $maxWidth, -1, IMG_BICUBIC);
            imagedestroy($image);
            $image = $resized;
        }

        // Conservar transparencia (PNG/WebP con alfa)
        imagealphablending($image, false);
        imagesavealpha($image, true);

        $filename = Str::uuid().'.webp';
        $targetDir = public_path($directory);
        File::ensureDirectoryExists($targetDir);

        imagewebp($image, $targetDir.DIRECTORY_SEPARATOR.$filename, self::WEBP_QUALITY);
        imagedestroy($image);

        return $filename;
    }

    public function delete(?string $filename, string $directory = self::DIRECTORY): void
    {
        if (! $filename) {
            return;
        }

        // basename() evita cualquier intento de path traversal desde la BD
        $path = public_path($directory.DIRECTORY_SEPARATOR.basename($filename));

        if (File::exists($path)) {
            File::delete($path);
        }
    }
}
