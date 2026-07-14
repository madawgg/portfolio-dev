<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateEmailRequest;
use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

/**
 * Gestión de la cuenta del admin: contraseña y email de acceso.
 */
class AccountController extends Controller
{
    public function edit(): View
    {
        return view('admin.account.edit');
    }

    public function updatePassword(UpdatePasswordRequest $request): RedirectResponse
    {
        $request->user()->update([
            'password' => Hash::make($request->validated()['password']),
        ]);

        // Regenerar la sesión tras el cambio: la sesión actual sigue válida
        // pero cualquier sesión robada previa deja de servir con el nuevo hash
        $request->session()->regenerate();

        return back()->with('status', 'Contraseña actualizada correctamente.');
    }

    public function updateEmail(UpdateEmailRequest $request): RedirectResponse
    {
        $request->user()->update([
            'email' => $request->validated()['email'],
        ]);

        $request->session()->regenerate();

        return back()->with('status', 'Email de acceso actualizado correctamente. Úsalo en tu próximo login.');
    }
}
