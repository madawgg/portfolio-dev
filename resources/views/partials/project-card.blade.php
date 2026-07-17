@php
    /** @var \App\Models\Project $project */
    $hover = $hover ?? false;          // resalte de borde/fondo (portada)
    $scaleOnHover = $scaleOnHover ?? false; // escala sutil (página de proyectos)
@endphp
<a href="{{ route('projects.show', $project) }}"
   class="group block h-full {{ $scaleOnHover ? 'transition-transform duration-200 will-change-transform hover:scale-[1.03]' : '' }}"
   aria-label="Ver el proyecto {{ $project->title }}">
    <article class="flex h-full flex-col overflow-hidden rounded-xl border border-slate-200 dark:border-slate-800 bg-white shadow-sm dark:bg-slate-900/50 dark:shadow-none
                    {{ $hover ? 'transition group-hover:border-emerald-500/40 group-hover:bg-slate-50 dark:group-hover:bg-slate-900' : '' }}">
        <div class="aspect-video w-full overflow-hidden bg-slate-200 dark:bg-slate-800">
            @if ($project->thumbnailUrl())
                <img src="{{ $project->thumbnailUrl() }}" alt="Miniatura de {{ $project->title }}"
                     class="h-full w-full object-cover {{ $hover ? 'transition duration-300 group-hover:scale-105' : '' }}" loading="lazy">
            @else
                <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-slate-200 dark:from-slate-800 to-slate-300 dark:to-slate-900">
                    <span class="font-mono text-4xl font-bold text-slate-400 dark:text-slate-600">{{ \Illuminate\Support\Str::substr($project->title, 0, 1) }}</span>
                </div>
            @endif
        </div>
        <div class="flex flex-1 flex-col p-5">
            @if ($project->category === 'profesional' && $project->company)
                <p class="mb-1 font-mono text-xs text-teal-600 dark:text-teal-300">{{ $project->company }}</p>
            @endif
            <h3 class="text-lg font-semibold text-slate-900 dark:text-white">{{ $project->title }}</h3>
            {{-- Descripción breve (o la completa recortada a 3 líneas con "…" si no hay breve) --}}
            <p class="mt-2 flex-1 text-sm leading-relaxed text-slate-600 dark:text-slate-400 line-clamp-3">{{ \Illuminate\Support\Str::limit($project->cardSummary(), 400, '…') }}</p>

            @if ($project->technologyList())
                <div class="mt-4 flex flex-wrap gap-2">
                    @foreach ($project->technologyList() as $tech)
                        <span class="rounded-full bg-emerald-500/10 px-2.5 py-1 font-mono text-xs text-emerald-600 dark:text-emerald-400">{{ $tech }}</span>
                    @endforeach
                </div>
            @endif

            <p class="mt-5 text-sm font-medium text-emerald-600 dark:text-emerald-400">Ver proyecto →</p>
        </div>
    </article>
</a>
