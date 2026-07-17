@extends('layouts.admin')

@section('title', $project ? 'Editar proyecto' : 'Nuevo proyecto')

@section('content')
    <div class="max-w-2xl">
        <form method="POST"
              action="{{ $project ? route('admin.proyectos.update', $project) : route('admin.proyectos.store') }}"
              enctype="multipart/form-data"
              class="space-y-5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white shadow-sm dark:bg-slate-900/50 dark:shadow-none p-6">
            @csrf
            @if ($project)
                @method('PUT')
            @endif

            <x-form.input label="Título" name="title" :value="$project?->title" required maxlength="255" />

            <x-form.textarea label="Descripción breve — se muestra en las tarjetas (máx. 300; si la dejas vacía se usa la completa recortada)" name="summary" :value="$project?->summary" rows="3" maxlength="300" />

            <x-form.textarea label="Descripción completa — página del proyecto" name="description" :value="$project?->description" rows="8" required maxlength="6000" />

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="category" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Categoría</label>
                    <select id="category" name="category" required
                            class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 px-4 py-2.5 text-slate-900 dark:text-white outline-none focus:border-emerald-500">
                        @foreach (['personal' => 'Personal', 'profesional' => 'Profesional'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('category', $project?->category ?? 'personal') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <x-form.input label="Empresa (para proyectos profesionales)" name="company" :value="$project?->company" maxlength="255" placeholder="Nombre de la empresa o cliente" />
            </div>

            <x-form.input label="Tecnologías (separadas por comas)" name="technologies" :value="$project?->technologies" maxlength="255" placeholder="PHP 8.2, Laravel 12, MySQL" />

            <div class="grid gap-5 sm:grid-cols-2">
                <x-form.input label="URL del repositorio (opcional)" name="repo_url" type="url" :value="$project?->repo_url" maxlength="255" placeholder="https://github.com/..." />
                <x-form.input label="URL de la demo (opcional)" name="demo_url" type="url" :value="$project?->demo_url" maxlength="255" placeholder="https://..." />
            </div>

            <div>
                <label for="thumbnail" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                    Miniatura (jpg, png o webp — se convierte automáticamente a WebP, máx. 4 MB)
                </label>
                @if ($project?->thumbnailUrl())
                    <div class="mb-3 flex items-center gap-4">
                        <img src="{{ $project->thumbnailUrl() }}" alt="Miniatura actual" class="h-24 rounded-lg object-cover">
                        <label class="flex cursor-pointer items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                            <input type="checkbox" name="remove_thumbnail" value="1" class="rounded border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900">
                            Quitar la miniatura actual (borra el archivo)
                        </label>
                    </div>
                @endif
                <input type="file" id="thumbnail" name="thumbnail" accept="image/jpeg,image/png,image/webp"
                       class="w-full cursor-pointer rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-sm text-slate-600 dark:text-slate-400 file:mr-4 file:cursor-pointer file:rounded-l-lg file:border-0 file:bg-slate-200 dark:file:bg-slate-800 file:px-4 file:py-2.5 file:text-slate-700 dark:file:text-slate-200">
            </div>

            <div>
                <label for="sort_order" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Orden (menor = aparece antes)</label>
                <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $project?->sort_order ?? 0) }}" min="0" max="65535"
                       class="w-32 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 px-4 py-2.5 text-slate-900 dark:text-white outline-none focus:border-emerald-500">
            </div>

            @if ($project)
                <div class="border-t border-slate-200 dark:border-slate-800 pt-5">
                    <label for="photos" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                        Fotos del proyecto (carrusel de la página de detalle — puedes seleccionar varias, máx. 12)
                    </label>
                    <input type="file" id="photos" name="photos[]" multiple accept="image/jpeg,image/png,image/webp"
                           class="w-full cursor-pointer rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-sm text-slate-600 dark:text-slate-400 file:mr-4 file:cursor-pointer file:rounded-l-lg file:border-0 file:bg-slate-200 dark:file:bg-slate-800 file:px-4 file:py-2.5 file:text-slate-700 dark:file:text-slate-200">
                </div>
            @else
                <p class="rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 px-4 py-3 text-sm text-slate-500">
                    Guarda el proyecto primero; después podrás añadir las fotos del carrusel desde "Editar".
                </p>
            @endif

            <div class="flex items-center gap-3">
                <button type="submit" class="rounded-lg bg-emerald-500 px-6 py-2.5 font-semibold text-slate-950 transition hover:bg-emerald-400">
                    {{ $project ? 'Guardar cambios' : 'Crear proyecto' }}
                </button>
                <a href="{{ route('admin.proyectos.index') }}" class="rounded-lg border border-slate-300 dark:border-slate-700 px-6 py-2.5 text-slate-700 dark:text-slate-300 transition hover:text-slate-900 dark:hover:text-white">Cancelar</a>
            </div>
        </form>

        @if ($project && $project->images->isNotEmpty())
            <div class="mt-6 rounded-xl border border-slate-200 dark:border-slate-800 bg-white shadow-sm dark:bg-slate-900/50 dark:shadow-none p-6">
                <h2 class="mb-4 font-semibold text-slate-900 dark:text-white">Fotos actuales del carrusel</h2>
                <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">
                    @foreach ($project->images as $image)
                        <div class="group relative overflow-hidden rounded-lg border border-slate-200 dark:border-slate-800">
                            <img src="{{ $image->url() }}" alt="Foto {{ $loop->iteration }}" class="aspect-video w-full object-cover">
                            <form method="POST" action="{{ route('admin.proyectos.imagenes.destroy', [$project, $image]) }}"
                                  onsubmit="return confirm('¿Eliminar esta foto?')"
                                  class="absolute right-2 top-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="rounded-lg border border-slate-300 dark:border-slate-700 bg-white/80 dark:bg-slate-950/80 px-2.5 py-1 text-xs text-slate-700 dark:text-slate-300 backdrop-blur transition hover:border-red-500/40 hover:text-red-600 dark:hover:text-red-400">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
