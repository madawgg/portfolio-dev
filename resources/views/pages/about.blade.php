@extends('layouts.app')

@section('title', 'Sobre mí')

@section('content')
    <section class="mx-auto max-w-4xl px-4 py-16 sm:px-6 sm:py-24">
        <h1 class="text-3xl font-bold text-slate-900 dark:text-white sm:text-4xl">Sobre mí</h1>

        {{-- Submenú de secciones (pegajoso bajo el navbar) --}}
        <nav aria-label="Secciones de esta página"
             class="sticky top-16 z-40 -mx-4 mt-6 border-y border-slate-200/80 dark:border-slate-800/80 bg-slate-50/90 dark:bg-slate-950/90 px-4 py-2 backdrop-blur sm:-mx-6 sm:px-6">
            <div class="flex gap-2">
                @foreach ([
                    '#experiencia' => '01. Experiencia',
                    '#formacion' => '02. Formación',
                ] as $anchor => $label)
                    <a href="{{ $anchor }}"
                       class="rounded-full border border-slate-300 dark:border-slate-700 px-4 py-1.5 font-mono text-sm text-slate-700 dark:text-slate-300 transition hover:border-emerald-500/50 hover:text-emerald-600 dark:hover:text-emerald-400">
                        {{ $label }}
                    </a>
                @endforeach
            </div>
        </nav>

        <div class="mt-6 space-y-4 text-lg leading-relaxed text-slate-600 dark:text-slate-400">
            {!! nl2br(e($profile->aboutText())) !!}
        </div>

        @if ($profile->hasCv())
            <a href="{{ route('cv.download') }}"
               class="mt-6 inline-flex items-center gap-2 rounded-lg border border-slate-300 dark:border-slate-700 px-5 py-2.5 text-sm font-semibold text-slate-800 dark:text-slate-200 transition hover:border-emerald-500/50 hover:text-emerald-600 dark:hover:text-emerald-400">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                </svg>
                Descargar CV en PDF
            </a>
        @endif

        {{-- Experiencia: tarjeta con tono esmeralda y línea de tiempo --}}
        <div id="experiencia"
             class="mt-12 scroll-mt-28 rounded-2xl border border-emerald-500/25 bg-emerald-500/5 p-6 dark:border-emerald-500/15 dark:bg-emerald-500/[0.04] sm:p-8">
            <h2 class="flex items-center gap-3 text-2xl font-bold text-slate-900 dark:text-white">
                <span class="font-mono text-emerald-600 dark:text-emerald-400">01.</span> Experiencia
            </h2>

            @if ($experiences->isEmpty())
                <p class="mt-6 text-slate-500">Todavía no hay experiencia publicada.</p>
            @else
                <ol class="relative mt-8 space-y-10 border-l-2 border-emerald-500/25 pl-8">
                    @foreach ($experiences as $experience)
                        <li class="relative">
                            {{-- Punto de la línea de tiempo --}}
                            <span class="absolute -left-[41px] top-1.5 h-4 w-4 rounded-full border-2
                                         {{ $experience->end_date ? 'border-emerald-500/40 bg-slate-50 dark:bg-slate-950' : 'border-emerald-400 bg-emerald-500/30' }}"></span>

                            <p class="font-mono text-sm text-emerald-600 dark:text-emerald-400">
                                {{ $experience->start_date->translatedFormat('M Y') }}
                                —
                                {{ $experience->end_date?->translatedFormat('M Y') ?? 'Actualidad' }}
                            </p>
                            <h3 class="mt-1 text-lg font-semibold text-slate-900 dark:text-white">
                                {{ $experience->position }}
                                <span class="font-normal text-slate-600 dark:text-slate-400">· {{ $experience->company }}</span>
                            </h3>
                            @if ($experience->description)
                                <p class="mt-2 leading-relaxed text-slate-600 dark:text-slate-400">{{ $experience->description }}</p>
                            @endif
                        </li>
                    @endforeach
                </ol>
            @endif
        </div>

        {{-- Formación: tarjeta con tono teal y tarjetas compactas --}}
        <div id="formacion"
             class="mt-10 scroll-mt-28 rounded-2xl border border-teal-500/25 bg-teal-500/5 p-6 dark:border-teal-500/15 dark:bg-teal-500/[0.04] sm:p-8">
            <h2 class="flex items-center gap-3 text-2xl font-bold text-slate-900 dark:text-white">
                <span class="font-mono text-teal-600 dark:text-teal-300">02.</span> Formación
            </h2>

            @if ($educations->isEmpty())
                <p class="mt-6 text-slate-500">Todavía no hay formación publicada.</p>
            @else
                <div class="mt-8 grid gap-5 sm:grid-cols-2">
                    @foreach ($educations as $education)
                        <div class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white shadow-sm dark:bg-slate-900/50 dark:shadow-none p-5 ">
                            <div class="flex items-start gap-3">
                                <svg class="mt-1 h-5 w-5 shrink-0 text-teal-600 dark:text-teal-300" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342"/>
                                </svg>
                                <div>
                                    <h3 class="font-semibold leading-snug text-slate-900 dark:text-white">{{ $education->degree }}</h3>
                                    <p class="mt-1 text-sm text-teal-600 dark:text-teal-300">{{ $education->institution }}</p>
                                    <p class="mt-1 font-mono text-xs text-slate-500">
                                        {{ $education->start_year }} — {{ $education->end_year ?? 'Actualidad' }}
                                    </p>
                                    @if ($education->description)
                                        <p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-400">{{ $education->description }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
