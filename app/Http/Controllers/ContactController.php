<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessageReceived;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class ContactController extends Controller
{
    /** Segundos mínimos entre cargar el formulario y enviarlo (los bots envían al instante). */
    private const MIN_SECONDS_TO_SUBMIT = 3;

    public function send(Request $request): RedirectResponse
    {
        // 1. Honeypot: el campo "website" está oculto por CSS; solo lo rellenan los bots.
        //    A los bots les respondemos con un falso éxito para no darles pistas.
        if ($request->filled('website')) {
            return $this->fakeSuccess();
        }

        // 2. Trampa de tiempo: sin visita previa al formulario (POST directo)
        //    o envío en menos de N segundos = bot.
        $renderedAt = session('contact_form_rendered_at');

        if (! $renderedAt || now()->timestamp - $renderedAt < self::MIN_SECONDS_TO_SUBMIT) {
            return $this->fakeSuccess();
        }

        // 3. Validación (email con comprobación DNS del dominio; el motivo
        //    rechaza caracteres de control para cortar inyecciones de cabeceras)
        $request->validate(
            [
                'sender_email' => ['required', 'email:rfc,dns', 'max:255'],
                'subject' => ['required', 'string', 'max:150', 'not_regex:/[\r\n\t]/'],
                'message' => ['required', 'string', 'min:10', 'max:2000'],
                'captcha' => ['required', 'integer'],
                'privacy' => ['accepted'],
            ],
            [
                'subject.not_regex' => 'El motivo contiene caracteres no permitidos.',
                'privacy.accepted' => 'Debes aceptar el aviso sobre el guardado de la IP para poder enviar el mensaje.',
            ],
            [
                'sender_email' => 'email',
                'subject' => 'motivo',
                'message' => 'mensaje',
                'captcha' => 'respuesta anti-spam',
                'privacy' => 'aviso de privacidad',
            ]
        );

        // 4. Captcha aritmético de un solo uso (la respuesta vive en la sesión)
        if ((int) $request->input('captcha') !== session('contact_captcha_answer')) {
            throw ValidationException::withMessages([
                'captcha' => 'La respuesta de la pregunta anti-spam no es correcta.',
            ]);
        }

        session()->forget(['contact_captcha_answer', 'contact_captcha_question', 'contact_form_rendered_at']);

        // La IP se guarda SOLO en la base de datos (motivos de seguridad);
        // no se muestra ni en el email ni en el panel.
        $contactMessage = ContactMessage::create([
            'sender_email' => $request->input('sender_email'),
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
            'ip' => $request->ip(),
        ]);

        try {
            Mail::to(config('mail.contact_to'))->send(new ContactMessageReceived($contactMessage));
        } catch (\Throwable $e) {
            // El mensaje ya está guardado en BD; si el SMTP falla no rompemos la web
            report($e);
        }

        return $this->fakeSuccess();
    }

    /**
     * Misma respuesta para envíos legítimos y para bots detectados:
     * un atacante no puede distinguir si su envío fue filtrado.
     */
    private function fakeSuccess(): RedirectResponse
    {
        return back()->with('status', '¡Gracias! Tu mensaje se ha enviado correctamente.');
    }
}
