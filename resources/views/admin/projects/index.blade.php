@extends('layouts.admin')

@section('title', 'Proyectos')

@section('content')
    <div class="mb-5 flex items-center justify-between">
        <p class="text-sm text-slate-600 dark:text-slate-400">{{ $projects->count() }} proyecto(s)</p>
        <a href="{{ route('admin.proyectos.create') }}"
           class="rounded-lg bg-emerald-500 px-4 py-2 text-sm font-semibold text-slate-950 transition hover:bg-emerald-400">
            + Nuevo proyecto
        </a>
    </div>

    <div class="overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-800 bg-white shadow-sm dark:bg-slate-900/50 dark:shadow-none">
        <table class="w-full min-w-[640px] text-left text-sm">
            <thead class="border-b border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400">
                <tr>
                    <th class="px-4 py-3 font-medium">Miniatura</th>
                    <th class="px-4 py-3 font-medium">Título</th>
                    <th class="px-4 py-3 font-medium">Categoría</th>
                    <th class="px-4 py-3 font-medium">Tecnologías</th>
                    <th class="px-4 py-3 font-medium">Orden</th>
                    <th class="px-4 py-3 font-medium text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                @forelse ($projects as $project)
                    <tr>
                        <td class="px-4 py-3">
                            @if ($project->thumbnailUrl())
                                <img src="{{ $project->thumbnailUrl() }}" alt="" class="h-12 w-20 rounded object-cover">
                            @else
                                <div class="flex h-12 w-20 items-center justify-center rounded bg-slate-200 dark:bg-slate-800 text-xs text-slate-500">Sin imagen</div>
                            @endif
                        </td>
                        <td class="px-4 py-3 font-medium text-slate-900 dark:text-white">{{ $project->title }}</td>
                        <td class="px-4 py-3">
                            @if ($project->category === 'profesional')
                                <span class="rounded-full bg-teal-500/10 px-2.5 py-1 text-xs text-teal-600 dark:text-teal-300">Profesional{{ $project->company ? ' · '.$project->company : '' }}</span>
                            @else
                                <span class="rounded-full bg-slate-200 dark:bg-slate-700/40 px-2.5 py-1 text-xs text-slate-700 dark:text-slate-300">Personal</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-slate-600 dark:text-slate-400">{{ $project->technologies }}</td>
                        <td class="px-4 py-3 text-slate-600 dark:text-slate-400">{{ $project->sort_order }}</td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.proyectos.edit', $project) }}"
                                   class="rounded-lg border border-slate-300 dark:border-slate-700 px-3 py-1.5 text-slate-700 dark:text-slate-300 transition hover:border-emerald-500/40 hover:text-emerald-600 dark:hover:text-emerald-400">Editar</a>
                                <form method="POST" action="{{ route('admin.proyectos.destroy', $project) }}"
                                      onsubmit="return confirm('¿Eliminar el proyecto «{{ $project->title }}»? Esta acción no se puede deshacer.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-lg border border-slate-300 dark:border-slate-700 px-3 py-1.5 text-slate-700 dark:text-slate-300 transition hover:border-red-500/40 hover:text-red-600 dark:hover:text-red-400">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-8 text-center text-slate-500">No hay proyectos todavía.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
