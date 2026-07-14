@extends('layouts.admin')

@section('title', 'Formación')

@section('content')
    <div class="mb-5 flex items-center justify-between">
        <p class="text-sm text-slate-600 dark:text-slate-400">{{ $educations->count() }} entrada(s)</p>
        <a href="{{ route('admin.formacion.create') }}"
           class="rounded-lg bg-emerald-500 px-4 py-2 text-sm font-semibold text-slate-950 transition hover:bg-emerald-400">
            + Nueva formación
        </a>
    </div>

    <div class="overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-800 bg-white shadow-sm dark:bg-slate-900/50 dark:shadow-none">
        <table class="w-full min-w-[640px] text-left text-sm">
            <thead class="border-b border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400">
                <tr>
                    <th class="px-4 py-3 font-medium">Título</th>
                    <th class="px-4 py-3 font-medium">Centro</th>
                    <th class="px-4 py-3 font-medium">Periodo</th>
                    <th class="px-4 py-3 font-medium text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                @forelse ($educations as $education)
                    <tr>
                        <td class="px-4 py-3 font-medium text-slate-900 dark:text-white">{{ $education->degree }}</td>
                        <td class="px-4 py-3 text-slate-600 dark:text-slate-400">{{ $education->institution }}</td>
                        <td class="px-4 py-3 text-slate-600 dark:text-slate-400">{{ $education->start_year }} — {{ $education->end_year ?? 'Actualidad' }}</td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.formacion.edit', $education) }}"
                                   class="rounded-lg border border-slate-300 dark:border-slate-700 px-3 py-1.5 text-slate-700 dark:text-slate-300 transition hover:border-emerald-500/40 hover:text-emerald-600 dark:hover:text-emerald-400">Editar</a>
                                <form method="POST" action="{{ route('admin.formacion.destroy', $education) }}"
                                      onsubmit="return confirm('¿Eliminar esta formación?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-lg border border-slate-300 dark:border-slate-700 px-3 py-1.5 text-slate-700 dark:text-slate-300 transition hover:border-red-500/40 hover:text-red-600 dark:hover:text-red-400">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-4 py-8 text-center text-slate-500">No hay formación todavía.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
