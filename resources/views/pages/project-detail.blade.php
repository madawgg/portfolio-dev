@extends('layouts.app')

@section('title', $project->title)
@section('meta_description', \Illuminate\Support\Str::limit($project->cardSummary(), 155))

@section('content')
    <section class="mx-auto max-w-4xl px-4 py-16 sm:px-6 sm:py-20">
        <a href="{{ route('projects') }}" class="text-sm font-medium text-slate-600 dark:text-slate-400 transition hover:text-emerald-600 dark:hover:text-emerald-400">← Volver a proyectos</a>

        <div class="mt-6 flex flex-wrap items-center gap-3">
            @if ($project->category === 'profesional')
                <span class="rounded-full bg-teal-500/10 px-3 py-1 text-xs font-medium text-teal-600 dark:text-teal-300">Proyecto profesional</span>
                @if ($project->company)
                    <span class="font-mono text-sm text-teal-600 dark:text-teal-300">{{ $project->company }}</span>
                @endif
            @else
                <span class="rounded-full bg-slate-200 dark:bg-slate-700/40 px-3 py-1 text-xs font-medium text-slate-700 dark:text-slate-300">Proyecto personal</span>
            @endif
        </div>

        <h1 class="mt-3 text-3xl font-bold text-slate-900 dark:text-white sm:text-4xl">{{ $project->title }}</h1>

        @if ($project->technologyList())
            <div class="mt-4 flex flex-wrap gap-2">
                @foreach ($project->technologyList() as $tech)
                    <span class="rounded-full bg-emerald-500/10 px-2.5 py-1 font-mono text-xs text-emerald-600 dark:text-emerald-400">{{ $tech }}</span>
                @endforeach
            </div>
        @endif

        <div class="mt-6 space-y-4 text-lg leading-relaxed text-slate-600 dark:text-slate-400">
            {!! nl2br(e($project->description)) !!}
        </div>

        @if ($project->repo_url || $project->demo_url)
            <div class="mt-8 flex flex-wrap gap-4">
                @if ($project->repo_url)
                    <a href="{{ $project->repo_url }}" target="_blank" rel="noopener noreferrer"
                       class="rounded-lg bg-emerald-500 px-6 py-3 font-semibold text-slate-950 transition hover:bg-emerald-400">Ver código ↗</a>
                @endif
                @if ($project->demo_url)
                    <a href="{{ $project->demo_url }}" target="_blank" rel="noopener noreferrer"
                       class="rounded-lg border border-slate-300 dark:border-slate-700 px-6 py-3 font-semibold text-slate-800 dark:text-slate-200 transition hover:border-emerald-500/50 hover:text-emerald-600 dark:hover:text-emerald-400">Ver demo ↗</a>
                @endif
            </div>
        @endif

        {{-- Carrusel de capturas --}}
        @if ($project->images->isNotEmpty())
            <h2 class="mt-14 text-xl font-bold text-slate-900 dark:text-white">Capturas</h2>

            <div class="relative mt-6">
                <div id="carousel" class="flex snap-x snap-mandatory gap-4 overflow-x-auto scroll-smooth rounded-xl pb-3
                                          [scrollbar-width:thin] [scrollbar-color:theme(colors.slate.700)_transparent]">
                    @foreach ($project->images as $image)
                        <img src="{{ $image->url() }}" alt="Captura {{ $loop->iteration }} de {{ $project->title }}"
                             class="h-64 w-auto shrink-0 snap-center rounded-xl border border-slate-200 dark:border-slate-800 object-contain sm:h-96"
                             loading="lazy">
                    @endforeach
                </div>

                @if ($project->images->count() > 1)
                    <button type="button" onclick="moverCarrusel(-1)" aria-label="Anterior"
                            class="absolute left-2 top-1/2 -translate-y-1/2 rounded-full border border-slate-300 dark:border-slate-700 bg-white/80 dark:bg-slate-950/80 p-2.5 text-slate-900 dark:text-white backdrop-blur transition hover:border-emerald-500/50 hover:text-emerald-600 dark:hover:text-emerald-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button type="button" onclick="moverCarrusel(1)" aria-label="Siguiente"
                            class="absolute right-2 top-1/2 -translate-y-1/2 rounded-full border border-slate-300 dark:border-slate-700 bg-white/80 dark:bg-slate-950/80 p-2.5 text-slate-900 dark:text-white backdrop-blur transition hover:border-emerald-500/50 hover:text-emerald-600 dark:hover:text-emerald-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </button>
                @endif
            </div>

            <script>
                function moverCarrusel(direccion) {
                    const c = document.getElementById('carousel');
                    c.scrollBy({ left: direccion * c.clientWidth * 0.8, behavior: 'smooth' });
                }
            </script>
        @endif
    </section>
@endsection
