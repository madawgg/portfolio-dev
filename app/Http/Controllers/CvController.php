<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Services\CvService;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CvController extends Controller
{
    public function __construct(
        private readonly CvService $cv,
    ) {}

    /** Fuerza la descarga del PDF (Content-Disposition: attachment). */
    public function download(): BinaryFileResponse
    {
        [$path, $downloadName] = $this->resolve();

        return response()->download($path, $downloadName, [
            'Content-Type' => 'application/pdf',
            // "attachment" fuerza descarga en lugar de abrirlo embebido,
            // y nosniff impide que el navegador reinterprete el contenido
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    /** Muestra el PDF en el navegador (Content-Disposition: inline). */
    public function view(): BinaryFileResponse
    {
        [$path, $downloadName] = $this->resolve();

        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'X-Content-Type-Options' => 'nosniff',
            // inline con nombre sugerido por si el visor nativo permite guardar
            'Content-Disposition' => 'inline; filename="'.$downloadName.'"',
        ]);
    }

    /**
     * Localiza el CV del perfil o aborta con 404.
     *
     * @return array{0: string, 1: string} [ruta absoluta, nombre de descarga]
     */
    private function resolve(): array
    {
        $profile = Profile::current();

        abort_unless((bool) $profile->cv_filename, 404);

        $path = $this->cv->path($profile->cv_filename);

        abort_unless((bool) $path, 404);

        // Nombre limpio y predecible (el nombre real en disco es un UUID)
        $downloadName = 'CV-'.Str::slug($profile->full_name ?: 'portfolio').'.pdf';

        return [$path, $downloadName];
    }
}
