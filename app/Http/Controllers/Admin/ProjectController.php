<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Services\ThumbnailService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function __construct(
        private readonly ThumbnailService $thumbnails,
    ) {}

    public function index(): View
    {
        return view('admin.projects.index', [
            'projects' => Project::orderBy('sort_order')->latest()->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.projects.form', ['project' => null]);
    }

    public function store(ProjectRequest $request): RedirectResponse
    {
        $data = $request->projectData();

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $this->thumbnails->store($request->file('thumbnail'));
        }

        Project::create($data);

        return redirect()->route('admin.proyectos.index')->with('status', 'Proyecto creado correctamente.');
    }

    public function edit(Project $project): View
    {
        return view('admin.projects.form', ['project' => $project]);
    }

    public function update(ProjectRequest $request, Project $project): RedirectResponse
    {
        $data = $request->projectData();

        if ($request->hasFile('thumbnail')) {
            $this->thumbnails->delete($project->thumbnail);
            $data['thumbnail'] = $this->thumbnails->store($request->file('thumbnail'));
        } elseif ($request->boolean('remove_thumbnail')) {
            $this->thumbnails->delete($project->thumbnail);
            $data['thumbnail'] = null;
        }

        $project->update($data);

        // Fotos de la galería (carrusel de la página de detalle)
        foreach ($request->file('photos', []) as $photo) {
            $project->images()->create([
                'filename' => $this->thumbnails->store($photo, ThumbnailService::GALLERY_DIRECTORY, 1600),
                'sort_order' => ($project->images()->max('sort_order') ?? 0) + 1,
            ]);
        }

        return redirect()->route('admin.proyectos.edit', $project)->with('status', 'Proyecto actualizado correctamente.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $this->thumbnails->delete($project->thumbnail);

        foreach ($project->images as $image) {
            $this->thumbnails->delete($image->filename, ThumbnailService::GALLERY_DIRECTORY);
        }

        $project->delete(); // las filas de imágenes caen por cascade

        return redirect()->route('admin.proyectos.index')->with('status', 'Proyecto eliminado.');
    }

    public function destroyImage(Project $project, ProjectImage $image): RedirectResponse
    {
        abort_unless($image->project_id === $project->id, 404);

        $this->thumbnails->delete($image->filename, ThumbnailService::GALLERY_DIRECTORY);
        $image->delete();

        return back()->with('status', 'Foto eliminada.');
    }
}
