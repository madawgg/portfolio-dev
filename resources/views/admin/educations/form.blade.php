@extends('layouts.admin')

@section('title', $education ? 'Editar formación' : 'Nueva formación')

@section('content')
    <div class="max-w-2xl">
        <form method="POST"
              action="{{ $education ? route('admin.formacion.update', $education) : route('admin.formacion.store') }}"
              class="space-y-5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white shadow-sm dark:bg-slate-900/50 dark:shadow-none p-6">
            @csrf
            @if ($education)
                @method('PUT')
            @endif

            <x-form.input label="Título / estudios" name="degree" :value="$education?->degree" required maxlength="255" />
            <x-form.input label="Centro / institución" name="institution" :value="$education?->institution" required maxlength="255" />

            <div class="grid gap-5 sm:grid-cols-3">
                <x-form.input label="Año de inicio" name="start_year" type="number" :value="$education?->start_year" required min="1970" max="2100" />
                <x-form.input label="Año de fin (vacío = en curso)" name="end_year" type="number" :value="$education?->end_year" min="1970" max="2100" />
                <x-form.input label="Orden" name="sort_order" type="number" :value="$education?->sort_order ?? 0" min="0" max="65535" />
            </div>

            <x-form.textarea label="Descripción (opcional)" name="description" :value="$education?->description" maxlength="3000" />

            <div class="flex items-center gap-3">
                <button type="submit" class="rounded-lg bg-emerald-500 px-6 py-2.5 font-semibold text-slate-950 transition hover:bg-emerald-400">
                    {{ $education ? 'Guardar cambios' : 'Crear formación' }}
                </button>
                <a href="{{ route('admin.formacion.index') }}" class="rounded-lg border border-slate-300 dark:border-slate-700 px-6 py-2.5 text-slate-700 dark:text-slate-300 transition hover:text-slate-900 dark:hover:text-white">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
