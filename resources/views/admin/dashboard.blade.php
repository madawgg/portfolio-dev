@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ([
            ['Proyectos', $projectCount, route('admin.proyectos.index')],
            ['Experiencias', $experienceCount, route('admin.experiencia.index')],
            ['Formación', $educationCount, route('admin.formacion.index')],
            ['Mensajes', $messageCount, route('admin.mensajes.index')],
        ] as [$label, $count, $url])
            <a href="{{ $url }}" class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white shadow-sm dark:bg-slate-900/50 dark:shadow-none p-5 transition hover:border-emerald-500/40">
                <p class="text-sm text-slate-600 dark:text-slate-400">{{ $label }}</p>
                <p class="mt-1 text-3xl font-bold text-slate-900 dark:text-white">{{ $count }}</p>
            </a>
        @endforeach
    </div>

    <div class="mt-8 rounded-xl border border-slate-200 dark:border-slate-800 bg-white shadow-sm dark:bg-slate-900/50 dark:shadow-none">
        <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-800 px-5 py-4">
            <h2 class="font-semibold text-slate-900 dark:text-white">Últimos mensajes</h2>
            <a href="{{ route('admin.mensajes.index') }}" class="text-sm text-emerald-600 dark:text-emerald-400 hover:text-emerald-500 dark:hover:text-emerald-300">Ver todos →</a>
        </div>
        @if ($latestMessages->isEmpty())
            <p class="px-5 py-6 text-sm text-slate-500">Todavía no has recibido ningún mensaje.</p>
        @else
            <ul class="divide-y divide-slate-200 dark:divide-slate-800">
                @foreach ($latestMessages as $message)
                    <li class="px-5 py-4">
                        <div class="flex flex-wrap items-baseline justify-between gap-2">
                            <p class="font-medium text-slate-900 dark:text-white">{{ $message->subject }}</p>
                            <p class="text-xs text-slate-500">{{ $message->created_at->diffForHumans() }}</p>
                        </div>
                        <p class="mt-1 text-sm text-emerald-600 dark:text-emerald-400">{{ $message->sender_email }}</p>
                        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">{{ \Illuminate\Support\Str::limit($message->message, 140) }}</p>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
