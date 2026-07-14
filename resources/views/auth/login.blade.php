@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <section class="mx-auto flex max-w-md flex-col justify-center px-4 py-24 sm:px-6">
        <div class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white shadow-sm dark:bg-slate-900/50 dark:shadow-none p-8">
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Acceso admin</h1>
            <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">Área privada de administración del portfolio.</p>

            <form method="POST" action="{{ route('login.attempt') }}" class="mt-8 space-y-5">
                @csrf

                <div>
                    <label for="email" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                           class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 px-4 py-3 text-slate-900 dark:text-white outline-none transition focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Contraseña</label>
                    <input type="password" id="password" name="password" required autocomplete="current-password"
                           class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 px-4 py-3 text-slate-900 dark:text-white outline-none transition focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                    @error('password')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="w-full rounded-lg bg-emerald-500 px-6 py-3 font-semibold text-slate-950 transition hover:bg-emerald-400">
                    Entrar
                </button>
            </form>
        </div>
    </section>
@endsection
