<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        return view('pages.home', [
            'profile' => Profile::current(),
            'featuredProjects' => Project::orderBy('sort_order')->latest()->take(3)->get(),
        ]);
    }

    public function about(): View
    {
        return view('pages.about', [
            'profile' => Profile::current(),
            'experiences' => Experience::orderBy('sort_order')->orderByDesc('start_date')->get(),
            'educations' => Education::orderBy('sort_order')->orderByDesc('start_year')->get(),
        ]);
    }

    public function projects(): View
    {
        $projects = Project::orderBy('sort_order')->latest()->get();

        return view('pages.projects', [
            'sections' => [
                ['title' => 'Proyectos profesionales', 'accent' => 'teal', 'anchor' => 'profesionales', 'short' => 'Profesionales', 'projects' => $projects->where('category', Project::CATEGORY_PROFESSIONAL)],
                ['title' => 'Proyectos personales', 'accent' => 'emerald', 'anchor' => 'personales', 'short' => 'Personales', 'projects' => $projects->where('category', Project::CATEGORY_PERSONAL)],
            ],
        ]);
    }

    public function projectShow(Project $project): View
    {
        return view('pages.project-detail', [
            'project' => $project->load('images'),
        ]);
    }

    public function contact(): View
    {
        // Captcha aritmético de un solo uso + marca de tiempo para la trampa
        // anti-bots (un humano tarda varios segundos en rellenar el formulario)
        $a = random_int(1, 9);
        $b = random_int(1, 9);

        session([
            'contact_captcha_answer' => $a + $b,
            'contact_captcha_question' => "¿Cuánto es {$a} + {$b}?",
            'contact_form_rendered_at' => now()->timestamp,
        ]);

        return view('pages.contact', [
            'profile' => Profile::current(),
        ]);
    }
}
