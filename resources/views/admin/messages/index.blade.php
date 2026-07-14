@extends('layouts.admin')

@section('title', 'Mensajes')

@section('content')
    @if ($messages->isEmpty())
        <div class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white shadow-sm dark:bg-slate-900/50 dark:shadow-none p-8 text-center text-slate-500">
            Todavía no has recibido ningún mensaje.
        </div>
    @else
        <div class="space-y-4">
            @foreach ($messages as $message)
                <article class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white shadow-sm dark:bg-slate-900/50 dark:shadow-none p-5">
                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <div>
                            <h2 class="font-semibold">
                                <a href="{{ route('admin.mensajes.show', $message) }}"
                                   class="text-slate-900 dark:text-white transition hover:text-emerald-600 dark:hover:text-emerald-400">{{ $message->subject }}</a>
                            </h2>
                            <p class="mt-1 text-sm">
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
                    <p class="mt-3 whitespace-pre-line text-sm leading-relaxed text-slate-700 dark:text-slate-300">{{ $message->message }}</p>
                </article>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $messages->links() }}
        </div>
    @endif
@endsection
