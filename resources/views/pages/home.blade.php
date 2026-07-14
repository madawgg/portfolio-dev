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

                    {{-- Redes: iconos junto a las acciones principales --}}
                    @if ($profile->github_url || $profile->linkedin_url)
                        <div class="flex items-center gap-1 sm:ml-1 sm:border-l sm:border-slate-300 sm:pl-4 sm:dark:border-slate-700">
                            @if ($profile->github_url)
                                <a href="{{ $profile->github_url }}" target="_blank" rel="noopener noreferrer" aria-label="GitHub"
                                   class="rounded-lg p-2 text-slate-600 dark:text-slate-400 transition hover:text-emerald-600 dark:hover:text-emerald-400">
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M12 0C5.37 0 0 5.37 0 12c0 5.3 3.438 9.8 8.205 11.387.6.113.82-.26.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61-.546-1.387-1.333-1.757-1.333-1.757-1.09-.744.082-.73.082-.73 1.205.086 1.84 1.238 1.84 1.238 1.07 1.834 2.807 1.304 3.492.997.108-.775.418-1.305.762-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.468-2.38 1.235-3.22-.123-.303-.535-1.523.117-3.176 0 0 1.008-.322 3.3 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.29-1.552 3.297-1.23 3.297-1.23.653 1.653.24 2.873.118 3.176.77.84 1.233 1.91 1.233 3.22 0 4.61-2.804 5.625-5.475 5.92.43.37.813 1.102.813 2.222 0 1.606-.015 2.898-.015 3.293 0 .32.216.694.825.576C20.565 21.796 24 17.3 24 12c0-6.63-5.37-12-12-12"/>
                                    </svg>
                                </a>
                            @endif
                            @if ($profile->linkedin_url)
                                <a href="{{ $profile->linkedin_url }}" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn"
                                   class="rounded-lg p-2 text-slate-600 dark:text-slate-400 transition hover:text-emerald-600 dark:hover:text-emerald-400">
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
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
