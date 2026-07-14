@extends('layouts.admin')

@section('title', 'Mensaje')

@section('content')
    <div class="max-w-2xl">
        <a href="{{ route('admin.mensajes.index') }}" class="text-sm font-medium text-slate-600 dark:text-slate-400 transition hover:text-emerald-600 dark:hover:text-emerald-400">← Volver a mensajes</a>

        <article class="mt-4 rounded-xl border border-slate-200 dark:border-slate-800 bg-white shadow-sm dark:bg-slate-900/50 dark:shadow-none p-6">
            <div class="flex flex-wrap items-start justify-between gap-3">
                <div>
                    <h1 class="text-xl font-bold text-slate-900 dark:text-white">{{ $message->subject }}</h1>
                    <p class="mt-2 text-sm">
                        <a href="mailto:{{ $message->sender_email }}" class="text-emerald-600 dark:text-emerald-400 hover:text-emerald-500 dark:hover:text-emerald-300">{{ $message->sender_email }}</a>
                        <span class="text-slate-500"> · {{ $message->created_at->format('d/m/Y H:i') }}</span>
                    </p>
                </div>
                <form method="POST" action="{{ route('admin.mensajes.destroy', $message) }}"
                      onsubmit="return confirm('¿Eliminar este mensaje?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="rounded-lg border border-slate-300 dark:border-slate-700 px-3 py-1.5 text-sm text-slate-700 dark:text-slate-300 transition hover:border-red-500/40 hover:text-red-600 dark:hover:text-red-400">Eliminar</button>
                </form>
            </div>

            <p class="mt-5 whitespace-pre-line leading-relaxed text-slate-700 dark:text-slate-300">{{ $message->message }}</p>

            <div class="mt-6 border-t border-slate-200 dark:border-slate-800 pt-4">
                <a href="mailto:{{ $message->sender_email }}?subject=Re: {{ rawurlencode($message->subject) }}"
                   class="rounded-lg bg-emerald-500 px-5 py-2.5 text-sm font-semibold text-slate-950 transition hover:bg-emerald-400">
                    Responder por email
                </a>
            </div>
        </article>
    </div>
@endsection
