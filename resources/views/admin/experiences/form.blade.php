@extends('layouts.admin')

@section('title', $experience ? 'Editar experiencia' : 'Nueva experiencia')

@section('content')
    <div class="max-w-2xl">
        <form method="POST"
              action="{{ $experience ? route('admin.experiencia.update', $experience) : route('admin.experiencia.store') }}"
              class="space-y-5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white shadow-sm dark:bg-slate-900/50 dark:shadow-none p-6">
            @csrf
            @if ($experience)
                @method('PUT')
            @endif

            <div class="grid gap-5 sm:grid-cols-2">
                <x-form.input label="Puesto" name="position" :value="$experience?->position" required maxlength="255" />
                <x-form.input label="Empresa" name="company" :value="$experience?->company" required maxlength="255" />
            </div>

            <x-form.textarea label="Descripción (opcional)" name="description" :value="$experience?->description" maxlength="3000" />

            <div class="grid gap-5 sm:grid-cols-3">
                <x-form.input label="Fecha de inicio" name="start_date" type="date" :value="$experience?->start_date?->format('Y-m-d')" required />
                <x-form.input label="Fecha de fin (vacío = actual)" name="end_date" type="date" :value="$experience?->end_date?->format('Y-m-d')" />
                <x-form.input label="Orden" name="sort_order" type="number" :value="$experience?->sort_order ?? 0" min="0" max="65535" />
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="rounded-lg bg-emerald-500 px-6 py-2.5 font-semibold text-slate-950 transition hover:bg-emerald-400">
                    {{ $experience ? 'Guardar cambios' : 'Crear experiencia' }}
                </button>
                <a href="{{ route('admin.experiencia.index') }}" class="rounded-lg border border-slate-300 dark:border-slate-700 px-6 py-2.5 text-slate-700 dark:text-slate-300 transition hover:text-slate-900 dark:hover:text-white">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
