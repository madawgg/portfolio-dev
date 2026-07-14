<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EducationController;
use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CvController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Zona pública
|--------------------------------------------------------------------------
*/
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/sobre-mi', [PageController::class, 'about'])->name('about');
Route::get('/proyectos', [PageController::class, 'projects'])->name('projects');
Route::get('/proyectos/{project}', [PageController::class, 'projectShow'])->name('projects.show');
Route::get('/contacto', [PageController::class, 'contact'])->name('contact');

Route::post('/contacto', [ContactController::class, 'send'])
    ->middleware('throttle:contact')
    ->name('contact.send');

Route::get('/cv', [CvController::class, 'download'])
    ->middleware('throttle:cv-download')
    ->name('cv.download');

/*
|--------------------------------------------------------------------------
| Autenticación
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Panel de administración (requiere sesión)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/perfil', [ProfileController::class, 'edit'])->name('perfil.edit');
    Route::put('/perfil', [ProfileController::class, 'update'])->name('perfil.update');

    Route::get('/cuenta', [AccountController::class, 'edit'])->name('cuenta.edit');
    Route::put('/cuenta/password', [AccountController::class, 'updatePassword'])->name('cuenta.password');
    Route::put('/cuenta/email', [AccountController::class, 'updateEmail'])->name('cuenta.email');

    Route::resource('proyectos', ProjectController::class)
        ->except(['show'])
        ->parameters(['proyectos' => 'project']);

    Route::delete('/proyectos/{project}/imagenes/{image}', [ProjectController::class, 'destroyImage'])
        ->name('proyectos.imagenes.destroy');

    Route::resource('experiencia', ExperienceController::class)
        ->except(['show'])
        ->parameters(['experiencia' => 'experience']);

    Route::resource('formacion', EducationController::class)
        ->except(['show'])
        ->parameters(['formacion' => 'education']);

    Route::get('/mensajes', [MessageController::class, 'index'])->name('mensajes.index');
    Route::get('/mensajes/{message}', [MessageController::class, 'show'])->name('mensajes.show');
    Route::delete('/mensajes/{message}', [MessageController::class, 'destroy'])->name('mensajes.destroy');
});
