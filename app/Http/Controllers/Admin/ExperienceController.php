<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExperienceRequest;
use App\Models\Experience;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ExperienceController extends Controller
{
    public function index(): View
    {
        return view('admin.experiences.index', [
            'experiences' => Experience::orderBy('sort_order')->orderByDesc('start_date')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.experiences.form', ['experience' => null]);
    }

    public function store(ExperienceRequest $request): RedirectResponse
    {
        Experience::create($request->validated());

        return redirect()->route('admin.experiencia.index')->with('status', 'Experiencia añadida correctamente.');
    }

    public function edit(Experience $experience): View
    {
        return view('admin.experiences.form', ['experience' => $experience]);
    }

    public function update(ExperienceRequest $request, Experience $experience): RedirectResponse
    {
        $experience->update($request->validated());

        return redirect()->route('admin.experiencia.index')->with('status', 'Experiencia actualizada correctamente.');
    }

    public function destroy(Experience $experience): RedirectResponse
    {
        $experience->delete();

        return redirect()->route('admin.experiencia.index')->with('status', 'Experiencia eliminada.');
    }
}
