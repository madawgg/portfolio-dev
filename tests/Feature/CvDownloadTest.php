<?php

namespace Tests\Feature;

use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CvDownloadTest extends TestCase
{
    use RefreshDatabase;

    public function test_sin_cv_subido_la_descarga_devuelve_404(): void
    {
        $this->get(route('cv.download'))->assertNotFound();
    }

    public function test_con_cv_subido_se_descarga_como_adjunto_pdf(): void
    {
        Storage::fake('local');
        Storage::disk('local')->put('cv/test.pdf', "%PDF-1.4\ncontenido");

        Profile::current()->update(['cv_filename' => 'test.pdf']);

        $response = $this->get(route('cv.download'));

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/pdf');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $this->assertStringContainsString('attachment', $response->headers->get('Content-Disposition'));
    }
}
