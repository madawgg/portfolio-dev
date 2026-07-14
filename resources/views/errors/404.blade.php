@extends('layouts.app')

@section('title', 'Página no encontrada')

@section('content')
    <section class="mx-auto flex max-w-2xl flex-col items-center px-4 py-24 text-center sm:py-32">
        <p class="font-mono text-7xl font-bold text-emerald-600 dark:text-emerald-400 sm:text-8xl">404</p>
        <h1 class="mt-6 text-2xl font-bold text-slate-900 dark:text-white sm:text-3xl">
            Esta página no existe
        </h1>
        <p class="mt-4 max-w-md text-lg text-slate-600 dark:text-slate-400">
            O nunca existió, o la borré en el último <span class="font-mono text-sm">git push --force</span>.
            Prometo que el resto de la web funciona mejor.
        </p>
        <div class="mt-10 flex flex-wrap justify-center gap-4">
            <a href="{{ route('home') }}"
               class="rounded-lg bg-emerald-500 px-6 py-3 font-semibold text-slate-950 transition hover:bg-emerald-400">
                Volver al inicio
            </a>
            <a href="{{ route('projects') }}"
               class="rounded-lg border border-slate-300 dark:border-slate-700 px-6 py-3 font-semibold text-slate-800 dark:text-slate-200 transition hover:border-emerald-500/50 hover:text-emerald-600 dark:hover:text-emerald-400">
                Ver proyectos
            </a>
        </div>
    </section>
@endsection
