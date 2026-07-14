@extends('layouts.admin')

@section('title', 'Perfil')

@section('content')
    <div class="max-w-2xl">
        <form method="POST" action="{{ route('admin.perfil.update') }}" enctype="multipart/form-data" class="space-y-5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white shadow-sm dark:bg-slate-900/50 dark:shadow-none p-6">
            @csrf
            @method('PUT')

            <div>
                <label for="photo" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                    Foto (jpg, png o webp — se convierte automáticamente a WebP, máx. 4 MB)
                </label>
                @if ($profile->photoUrl())
                    <div class="mb-3 flex items-center gap-4">
                        <img src="{{ $profile->photoUrl() }}" alt="Foto actual" class="h-24 w-24 rounded-full object-cover ring-2 ring-emerald-500/40">
                        <label class="flex cursor-pointer items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                            <input type="checkbox" name="remove_photo" value="1" class="rounded border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900">
                            Quitar la foto actual
                        </label>
                    </div>
                @endif
                <input type="file" id="photo" name="photo" accept="image/jpeg,image/png,image/webp"
                       class="w-full cursor-pointer rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-sm text-slate-600 dark:text-slate-400 file:mr-4 file:cursor-pointer file:rounded-l-lg file:border-0 file:bg-slate-200 dark:file:bg-slate-800 file:px-4 file:py-2.5 file:text-slate-700 dark:file:text-slate-200">
            </div>

            <div>
                <label for="cv" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                    CV en PDF (máx. 4 MB — se ofrece con el botón "Descargar CV" de la web)
                </label>
                @if ($profile->hasCv())
                    <div class="mb-3 flex flex-wrap items-center gap-4">
                        <a href="{{ route('cv.download') }}"
                           class="rounded-lg border border-emerald-500/40 px-3 py-1.5 text-sm font-medium text-emerald-600 dark:text-emerald-400 transition hover:bg-emerald-500/10">
                            Descargar CV actual
                        </a>
                        <label class="flex cursor-pointer items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                            <input type="checkbox" name="remove_cv" value="1" class="rounded border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900">
                            Quitar el CV actual
                        </label>
                    </div>
                @else
                    <p class="mb-3 text-sm text-slate-500">No hay CV subido: el botón de descarga no se muestra en la web.</p>
                @endif
                <input type="file" id="cv" name="cv" accept="application/pdf"
                       class="w-full cursor-pointer rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-sm text-slate-600 dark:text-slate-400 file:mr-4 file:cursor-pointer file:rounded-l-lg file:border-0 file:bg-slate-200 dark:file:bg-slate-800 file:px-4 file:py-2.5 file:text-slate-700 dark:file:text-slate-200">
                <p class="mt-2 text-xs text-slate-500">
                    Consejo: usa una versión "pública" del CV sin datos sensibles (sin dirección completa, teléfono personal ni DNI).
                </p>
            </div>

            <x-form.input label="Nombre completo" name="full_name" :value="$profile->full_name" required maxlength="255" />

            <x-form.input label='Titular (ej. "Desarrollador web full-stack")' name="headline" :value="$profile->headline" required maxlength="255" />

            <x-form.textarea label="Presentación breve — se muestra en la portada (máx. 1000 caracteres)" name="bio" :value="$profile->bio" required maxlength="1000" />

            <x-form.textarea label='Sobre mí — texto largo de la página "Sobre mí" (si lo dejas vacío, se usa la presentación breve)' name="about" :value="$profile->about" rows="12" maxlength="10000" />

            <x-form.input label="Email público (opcional)" name="public_email" type="email" :value="$profile->public_email" maxlength="255" />

            <div class="grid gap-5 sm:grid-cols-2">
                <x-form.input label="GitHub (opcional)" name="github_url" type="url" :value="$profile->github_url" maxlength="255" placeholder="https://github.com/usuario" />
                <x-form.input label="LinkedIn (opcional)" name="linkedin_url" type="url" :value="$profile->linkedin_url" maxlength="255" placeholder="https://linkedin.com/in/usuario" />
            </div>

            <button type="submit" class="rounded-lg bg-emerald-500 px-6 py-2.5 font-semibold text-slate-950 transition hover:bg-emerald-400">
                Guardar cambios
            </button>
        </form>
    </div>
@endsection
