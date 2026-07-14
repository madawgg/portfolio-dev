@extends('layouts.admin')

@section('title', 'Cuenta')

@section('content')
    <div class="max-w-md space-y-6">
        <form method="POST" action="{{ route('admin.cuenta.password') }}" class="space-y-5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white shadow-sm dark:bg-slate-900/50 dark:shadow-none p-6">
            @csrf
            @method('PUT')

            <div>
                <h2 class="font-semibold text-slate-900 dark:text-white">Cambiar contraseña</h2>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Mínimo 10 caracteres, con letras y números.</p>
            </div>

            <x-form.input label="Contraseña actual" name="current_password" type="password" required autocomplete="current-password" />
            <x-form.input label="Nueva contraseña" name="password" type="password" required autocomplete="new-password" />
            <x-form.input label="Repite la nueva contraseña" name="password_confirmation" type="password" required autocomplete="new-password" />

            <button type="submit" class="rounded-lg bg-emerald-500 px-6 py-2.5 font-semibold text-slate-950 transition hover:bg-emerald-400">
                Cambiar contraseña
            </button>
        </form>

        <form method="POST" action="{{ route('admin.cuenta.email') }}" class="space-y-5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white shadow-sm dark:bg-slate-900/50 dark:shadow-none p-6">
            @csrf
            @method('PUT')

            <div>
                <h2 class="font-semibold text-slate-900 dark:text-white">Cambiar email de acceso</h2>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                    Email actual: <span class="font-mono text-emerald-600 dark:text-emerald-400">{{ auth()->user()->email }}</span>
                </p>
            </div>

            <x-form.input label="Nuevo email" name="email" type="email" required maxlength="255" autocomplete="email" />
            <x-form.input label="Contraseña actual (para confirmar)" name="current_password" type="password" required autocomplete="current-password" />

            <button type="submit" class="rounded-lg bg-emerald-500 px-6 py-2.5 font-semibold text-slate-950 transition hover:bg-emerald-400">
                Cambiar email
            </button>
        </form>
    </div>
@endsection
