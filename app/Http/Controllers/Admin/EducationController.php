<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EducationRequest;
use App\Models\Education;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EducationController extends Controller
{
    public function index(): View
    {
        return view('admin.educations.index', [
            'educations' => Education::orderBy('sort_order')->orderByDesc('start_year')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.educations.form', ['education' => null]);
    }

    public function store(EducationRequest $request): RedirectResponse
    {
        Education::create($request->validated());

        return redirect()->route('admin.formacion.index')->with('status', 'Formación añadida correctamente.');
    }

    public function edit(Education $education): View
    {
        return view('admin.educations.form', ['education' => $education]);
    }

    public function update(EducationRequest $request, Education $education): RedirectResponse
    {
        $education->update($request->validated());

        return redirect()->route('admin.formacion.index')->with('status', 'Formación actualizada correctamente.');
    }

    public function destroy(Education $education): RedirectResponse
    {
        $education->delete();

        return redirect()->route('admin.formacion.index')->with('status', 'Formación eliminada.');
    }
}
