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

    public function download(): BinaryFileResponse
    {
        $profile = Profile::current();

        abort_unless((bool) $profile->cv_filename, 404);

        $path = $this->cv->path($profile->cv_filename);

        abort_unless((bool) $path, 404);

        // Nombre de descarga limpio y predecible (el nombre real en disco es un UUID)
        $downloadName = 'CV-'.Str::slug($profile->full_name ?: 'portfolio').'.pdf';

        return response()->download($path, $downloadName, [
            'Content-Type' => 'application/pdf',
            // "attachment" fuerza descarga en lugar de abrirlo embebido,
            // y nosniff impide que el navegador reinterprete el contenido
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }
}
