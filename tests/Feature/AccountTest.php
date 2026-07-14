<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use RefreshDatabase;

    public function test_no_se_cambia_la_contrasena_sin_la_actual_correcta(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->put(route('admin.cuenta.password'), [
            'current_password' => 'incorrecta',
            'password' => 'NuevaClave2026',
            'password_confirmation' => 'NuevaClave2026',
        ])->assertSessionHasErrors('current_password');

        $this->assertTrue(Hash::check('password', $user->fresh()->password));
    }

    public function test_la_contrasena_se_cambia_con_la_actual_correcta(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->put(route('admin.cuenta.password'), [
            'current_password' => 'password',
            'password' => 'NuevaClave2026',
            'password_confirmation' => 'NuevaClave2026',
        ])->assertSessionHas('status');

        $this->assertTrue(Hash::check('NuevaClave2026', $user->fresh()->password));
    }

    public function test_el_email_de_acceso_se_cambia_con_la_contrasena_correcta(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->put(route('admin.cuenta.email'), [
            'email' => 'nuevo@correo.com',
            'current_password' => 'password',
        ])->assertSessionHas('status');

        $this->assertSame('nuevo@correo.com', $user->fresh()->email);
    }

    public function test_el_email_no_se_cambia_sin_la_contrasena_correcta(): void
    {
        $user = User::factory()->create();
        $original = $user->email;

        $this->actingAs($user)->put(route('admin.cuenta.email'), [
            'email' => 'nuevo@correo.com',
            'current_password' => 'incorrecta',
        ])->assertSessionHasErrors('current_password');

        $this->assertSame($original, $user->fresh()->email);
    }
}
