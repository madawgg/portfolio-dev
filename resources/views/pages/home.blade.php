@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
    {{-- Hero --}}
    <section class="relative overflow-hidden">
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_at_top,rgba(16,185,129,0.12),transparent_60%)]"></div>
        <div class="mx-auto flex max-w-6xl flex-col-reverse items-center gap-12 px-4 py-24 sm:px-6 sm:py-32 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="mb-4 font-mono text-sm text-emerald-600 dark:text-emerald-400">Hola, me llamo</p>
                <h1 class="max-w-3xl text-4xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-6xl">
                    {{ $profile->full_name }}.
                    <span class="mt-2 block bg-gradient-to-r from-emerald-600 dark:from-emerald-400 to-teal-500 dark:to-teal-300 bg-clip-text text-transparent">
                        {{ $profile->headline }}
                    </span>
                </h1>
                <p class="mt-6 max-w-2xl text-lg leading-relaxed text-slate-600 dark:text-slate-400">
                    {{ \Illuminate\Support\Str::limit(strip_tags($profile->bio), 220) }}
                </p>
                <div class="mt-10 flex flex-wrap items-center gap-4">
                    <a href="{{ route('projects') }}"
                       class="rounded-lg bg-emerald-500 px-6 py-3 font-semibold text-slate-950 transition hover:bg-emerald-400">
                        Ver mis proyectos
                    </a>
                    <a href="{{ route('contact') }}"
                       class="rounded-lg border border-slate-300 dark:border-slate-700 px-6 py-3 font-semibold text-slate-800 dark:text-slate-200 transition hover:border-emerald-500/50 hover:text-emerald-600 dark:hover:text-emerald-400">
                        Contactar
                    </a>
                    @if ($profile->hasCv())
                        <a href="{{ route('cv.download') }}"
                           class="inline-flex items-center gap-2 rounded-lg border border-slate-300 dark:border-slate-700 px-6 py-3 font-semibold text-slate-800 dark:text-slate-200 transition hover:border-emerald-500/50 hover:text-emerald-600 dark:hover:text-emerald-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                            </svg>
                            Descargar CV
                        </a>
                    @endif
                </div>
            </div>

            @if ($profile->photoUrl())
                <div class="shrink-0">
                    <div class="relative">
                        <div class="absolute -inset-3 rounded-full bg-gradient-to-tr from-emerald-500/30 to-teal-400/10 blur-xl"></div>
                        <img src="{{ $profile->photoUrl() }}" alt="Foto de {{ $profile->full_name }}"
                             class="relative h-48 w-48 rounded-full object-cover ring-4 ring-emerald-500/40 sm:h-64 sm:w-64">
                    </div>
                </div>
            @endif
        </div>
    </section>

    {{-- Proyectos destacados --}}
    @if ($featuredProjects->isNotEmpty())
        <section class="mx-auto max-w-6xl px-4 pb-24 sm:px-6">
            <div class="mb-8 flex items-end justify-between">
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white sm:text-3xl">Proyectos destacados</h2>
                <a href="{{ route('projects') }}" class="text-sm font-medium text-emerald-600 dark:text-emerald-400 hover:text-emerald-500 dark:hover:text-emerald-300">Ver todos →</a>
            </div>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($featuredProjects as $project)
                    @include('partials.project-card', ['project' => $project, 'hover' => true])
                @endforeach
            </div>
        </section>
    @endif
@endsection
