<?php

namespace Database\Seeders;

use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    /**
     * Datos de ejemplo para que el portfolio no arranque vacío.
     * Todo es editable (o borrable) desde el panel de administración.
     */
    public function run(): void
    {
        if (Profile::count() === 0) {
            Profile::create([
                'full_name' => 'Miguel',
                'headline' => 'Desarrollador web full-stack',
                'bio' => 'Desarrollador web junior especializado en PHP/Laravel y React. Me gusta construir aplicaciones completas, del modelo de datos a la interfaz, con especial atención a la seguridad y al detalle.',
                'about' => "Desarrollador web junior especializado en PHP/Laravel y React. Me gusta construir aplicaciones completas, del modelo de datos a la interfaz, con especial atención a la seguridad y al detalle.\n\nEdita este texto largo (y la presentación breve de la portada) desde el panel de administración.",
                'public_email' => 'migueldaw24@gmail.com',
                'github_url' => 'https://github.com/madawgg',
                'linkedin_url' => null,
            ]);
        }

        if (Education::count() === 0) {
            Education::create([
                'degree' => 'Grado Superior en Desarrollo de Aplicaciones Web (DAW)',
                'institution' => 'Edita tu centro de estudios',
                'start_year' => 2023,
                'end_year' => 2025,
                'description' => 'Formación en desarrollo web front-end y back-end: PHP, Laravel, JavaScript, bases de datos y despliegue.',
                'sort_order' => 1,
            ]);
        }

        if (Experience::count() === 0) {
            Experience::create([
                'position' => 'Desarrollador web (proyecto real)',
                'company' => 'FisioWorks — clínica de fisioterapia',
                'description' => 'Aplicación de gestión completa para una clínica real: API en Laravel con Sanctum y front SPA en React. Citas, bonos, historiales médicos y roles de usuario.',
                'start_date' => '2025-01-01',
                'end_date' => null,
                'sort_order' => 1,
            ]);
        }

        if (Project::count() === 0) {
            Project::create([
                'title' => 'Gestión de ganadería',
                'description' => 'Plataforma para la gestión integral de una explotación ganadera, contenerizada y desplegada con Docker. Código privado (proyecto para empresa).',
                'technologies' => 'Ruby on Rails, Docker, MySQL',
                'category' => Project::CATEGORY_PROFESSIONAL,
                'company' => null,
                'repo_url' => null,
                'demo_url' => null,
                'sort_order' => 1,
            ]);

            Project::create([
                'title' => 'FisioWorks — API',
                'description' => 'Backend de gestión para una clínica de fisioterapia: autenticación con roles, citas con disponibilidad real, bonos de sesiones e historiales médicos.',
                'technologies' => 'PHP 8.2, Laravel 12, Sanctum, MySQL',
                'category' => Project::CATEGORY_PERSONAL,
                'repo_url' => 'https://github.com/madawgg/FisioWorks_API',
                'demo_url' => null,
                'sort_order' => 1,
            ]);

            Project::create([
                'title' => 'FisioWorks — Front',
                'description' => 'SPA en React para la gestión de la clínica: agenda con FullCalendar, reservas, panel de administración y modo demo de solo lectura.',
                'technologies' => 'React 19, Vite, React Router 7, Bootstrap 5',
                'category' => Project::CATEGORY_PERSONAL,
                'repo_url' => 'https://github.com/madawgg/fisioWorks_front',
                'demo_url' => null,
                'sort_order' => 2,
            ]);
        }
    }
}
