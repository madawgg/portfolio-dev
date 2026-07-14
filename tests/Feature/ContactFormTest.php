<?php

namespace Tests\Feature;

use App\Mail\ContactMessageReceived;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Carga el formulario (genera captcha y marca de tiempo en sesión)
     * y avanza el reloj para superar la trampa de tiempo anti-bots.
     */
    private function loadForm(): int
    {
        $this->get(route('contact'))->assertOk();
        $this->travel(5)->seconds();

        return (int) session('contact_captcha_answer');
    }

    private function validPayload(int $captcha, array $overrides = []): array
    {
        return array_merge([
            'sender_email' => 'reclutador@gmail.com',
            'subject' => 'Oferta de trabajo',
            'message' => 'Hola, nos gustaría hablar contigo sobre una posición.',
            'captcha' => $captcha,
            'privacy' => '1',
        ], $overrides);
    }

    public function test_un_envio_valido_guarda_el_mensaje_y_envia_el_correo(): void
    {
        Mail::fake();
        $captcha = $this->loadForm();

        $this->post(route('contact.send'), $this->validPayload($captcha))
            ->assertRedirect()
            ->assertSessionHas('status');

        $this->assertDatabaseCount('contact_messages', 1);
        $this->assertDatabaseHas('contact_messages', ['sender_email' => 'reclutador@gmail.com']);
        Mail::assertSent(ContactMessageReceived::class, 1);
    }

    public function test_el_honeypot_descarta_el_envio_con_falso_exito(): void
    {
        Mail::fake();
        $captcha = $this->loadForm();

        $this->post(route('contact.send'), $this->validPayload($captcha, ['website' => 'soy-un-bot']))
            ->assertRedirect()
            ->assertSessionHas('status'); // falso éxito: el bot no sabe que fue filtrado

        $this->assertDatabaseCount('contact_messages', 0);
        Mail::assertNothingSent();
    }

    public function test_un_envio_demasiado_rapido_se_descarta_como_bot(): void
    {
        Mail::fake();
        $this->get(route('contact'));
        $captcha = (int) session('contact_captcha_answer');

        // Envío inmediato, sin esperar los 3 segundos mínimos
        $this->post(route('contact.send'), $this->validPayload($captcha))
            ->assertRedirect()
            ->assertSessionHas('status');

        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_un_captcha_incorrecto_rechaza_el_envio(): void
    {
        $captcha = $this->loadForm();

        $this->post(route('contact.send'), $this->validPayload($captcha + 1))
            ->assertSessionHasErrors('captcha');

        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_sin_aceptar_el_aviso_de_privacidad_no_se_envia(): void
    {
        $captcha = $this->loadForm();
        $payload = $this->validPayload($captcha);
        unset($payload['privacy']);

        $this->post(route('contact.send'), $payload)
            ->assertSessionHasErrors('privacy');

        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_el_limite_por_ip_bloquea_el_cuarto_envio_en_una_hora(): void
    {
        Mail::fake();

        foreach (range(1, 3) as $i) {
            $captcha = $this->loadForm();
            $this->post(route('contact.send'), $this->validPayload($captcha))
                ->assertSessionHas('status');
        }

        $this->assertDatabaseCount('contact_messages', 3);

        $captcha = $this->loadForm();
        $this->post(route('contact.send'), $this->validPayload($captcha))
            ->assertSessionHasErrors('message'); // "Has enviado demasiados mensajes..."

        $this->assertDatabaseCount('contact_messages', 3);
    }
}
