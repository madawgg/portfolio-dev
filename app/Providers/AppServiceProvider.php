<?php

namespace App\Providers;

use App\Models\Profile;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // El layout público necesita el perfil (nombre, redes) en todas las páginas
        View::composer('layouts.app', function ($view) {
            $view->with('siteProfile', Profile::current());
        });

        // Límite anti-spam del formulario de contacto:
        // por IP (3/hora y 6/día) y por email del remitente (5/hora),
        // para que cambiar de IP no permita reutilizar el mismo correo.
        RateLimiter::for('contact', function (Request $request) {
            $email = Str::lower(trim((string) $request->input('sender_email')));

            return [
                Limit::perHour(3)->by('contact-h:'.$request->ip())->response(
                    fn () => back()->withErrors([
                        'message' => 'Has enviado demasiados mensajes. Inténtalo de nuevo más tarde.',
                    ])->withInput()
                ),
                Limit::perDay(6)->by('contact-d:'.$request->ip())->response(
                    fn () => back()->withErrors([
                        'message' => 'Has alcanzado el límite diario de mensajes. Inténtalo mañana.',
                    ])->withInput()
                ),
                Limit::perHour(5)->by('contact-e:'.sha1($email))->response(
                    fn () => back()->withErrors([
                        'message' => 'Este correo ha enviado demasiados mensajes. Inténtalo de nuevo más tarde.',
                    ])->withInput()
                ),
            ];
        });

        // Descarga del CV: evita que un bot consuma ancho de banda o
        // scrapee el PDF en bucle. Un reclutador real no necesita más.
        RateLimiter::for('cv-download', function (Request $request) {
            return [
                Limit::perHour(10)->by('cv-h:'.$request->ip()),
                Limit::perDay(20)->by('cv-d:'.$request->ip()),
            ];
        });
    }
}
