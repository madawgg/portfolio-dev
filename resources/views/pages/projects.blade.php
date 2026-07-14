@extends('layouts.app')

@section('title', 'Proyectos')

@section('content')
    <section class="mx-auto max-w-6xl px-4 py-16 sm:px-6 sm:py-24">
        <h1 class="text-3xl font-bold text-slate-900 dark:text-white sm:text-4xl">Proyectos</h1>
        <p class="mt-4 max-w-2xl text-lg text-slate-600 dark:text-slate-400">
            Una selección de los proyectos en los que he trabajado.
        </p>

        @php $hasAny = collect($sections)->contains(fn ($s) => $s['projects']->isNotEmpty()); @endphp

        @unless ($hasAny)
            <p class="mt-12 text-slate-500">Todavía no hay proyectos publicados. ¡Vuelve pronto!</p>
        @endunless

        @php
            // Clases literales completas para que Tailwind las detecte al compilar
            $cardTones = [
                'teal' => 'border-teal-500/25 bg-teal-500/5 dark:border-teal-500/15 dark:bg-teal-500/[0.04]',
                'emerald' => 'border-emerald-500/25 bg-emerald-500/5 dark:border-emerald-500/15 dark:bg-emerald-500/[0.04]',
            ];
            $numberTones = [
                'teal' => 'text-teal-600 dark:text-teal-300',
                'emerald' => 'text-emerald-600 dark:text-emerald-400',
            ];
        @endphp

        @foreach ($sections as $index => $section)
            @if ($section['projects']->isNotEmpty())
                <div class="mt-10 rounded-2xl border p-6 sm:p-8 {{ $cardTones[$section['accent']] }}">
                    <h2 class="flex items-center gap-3 text-xl font-bold text-slate-900 dark:text-white sm:text-2xl">
                        <span class="font-mono {{ $numberTones[$section['accent']] }}">0{{ $index + 1 }}.</span>
                        {{ $section['title'] }}
                        <span class="rounded-full bg-slate-200 dark:bg-slate-800 px-2.5 py-0.5 text-xs font-normal text-slate-600 dark:text-slate-400">{{ $section['projects']->count() }}</span>
                    </h2>

                    {{-- Fila estilo Netflix: scroll horizontal cuando no caben (sangra hasta el borde de la tarjeta) --}}
                    {{-- py-2 da margen vertical para que la escala del hover no se recorte --}}
                    <div class="-mx-6 mt-4 overflow-x-auto px-6 py-2 pb-4 sm:-mx-8 sm:px-8 [scrollbar-width:thin] [scrollbar-color:theme(colors.slate.700)_transparent]">
                        <div class="flex snap-x snap-mandatory gap-5">
                            @foreach ($section['projects'] as $project)
                                <div class="w-72 shrink-0 snap-start sm:w-80">
                                    @include('partials.project-card', ['project' => $project, 'scaleOnHover' => true])
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </section>
@endsection
