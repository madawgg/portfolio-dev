@extends('layouts.app')

@section('title', 'Contacto')

@section('content')
    <section class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24">
        <h1 class="text-3xl font-bold text-slate-900 dark:text-white sm:text-4xl">Contacto</h1>
        <p class="mt-4 text-lg text-slate-600 dark:text-slate-400">
            ¿Tienes una oferta, una propuesta o simplemente quieres saludar? Escríbeme y te responderé lo antes posible.
        </p>

        @if (session('status'))
            <div class="mt-8 rounded-lg border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-emerald-700 dark:text-emerald-300">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mt-8 rounded-lg border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-700 dark:text-red-300">
                <ul class="list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('contact.send') }}"
              class="mt-10 space-y-6 rounded-2xl border border-slate-200 dark:border-slate-800 bg-white shadow-sm dark:bg-slate-900/50 dark:shadow-none p-6 sm:p-8">
            @csrf

            {{-- Honeypot anti-bots: oculto para humanos, los bots lo rellenan --}}
            <div style="position:absolute;left:-9999px;top:-9999px" aria-hidden="true">
                <label for="website">No rellenes este campo</label>
                <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
            </div>

            <div>
                <label for="sender_email" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Tu email</label>
                <input type="email" id="sender_email" name="sender_email" value="{{ old('sender_email') }}" required maxlength="255"
                       class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 px-4 py-3 text-slate-900 dark:text-white placeholder-slate-500 outline-none transition focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500"
                       placeholder="tu@email.com">
            </div>

            <div>
                <label for="subject" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Motivo</label>
                <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required maxlength="150"
                       class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 px-4 py-3 text-slate-900 dark:text-white placeholder-slate-500 outline-none transition focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500"
                       placeholder="Oferta de trabajo, colaboración...">
            </div>

            <div>
                <label for="message" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Mensaje</label>
                <textarea id="message" name="message" rows="6" required minlength="10" maxlength="2000"
                          class="w-full resize-y rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 px-4 py-3 text-slate-900 dark:text-white placeholder-slate-500 outline-none transition focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500"
                          placeholder="Cuéntame en qué puedo ayudarte...">{{ old('message') }}</textarea>
            </div>

            <div>
                <label for="captcha" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                    Pregunta anti-spam: <span class="font-semibold text-emerald-600 dark:text-emerald-400">{{ session('contact_captcha_question') }}</span>
                </label>
                <input type="number" id="captcha" name="captcha" required inputmode="numeric"
                       class="w-32 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 px-4 py-3 text-slate-900 dark:text-white outline-none transition focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500"
                       placeholder="Respuesta">
            </div>

            <label class="flex items-start gap-3 text-sm text-slate-600 dark:text-slate-400">
                <input type="checkbox" name="privacy" value="1" required
                       class="mt-0.5 h-4 w-4 shrink-0 rounded border-slate-300 dark:border-slate-700 accent-emerald-500">
                <span>
                    Acepto que al enviar este formulario se guarde mi dirección IP por motivos de seguridad
                    y prevención de abusos. No se usará para nada más ni se compartirá con terceros.
                </span>
            </label>

            <button type="submit"
                    class="w-full rounded-lg bg-emerald-500 px-6 py-3 font-semibold text-slate-950 transition hover:bg-emerald-400 sm:w-auto">
                Enviar mensaje
            </button>
        </form>
    </section>
@endsection
