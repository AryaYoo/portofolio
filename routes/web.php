<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

// ─── Portfolio (Public) ────────────────────────────────────
Route::get('/', [PortfolioController::class, 'index'])->name('portfolio');
Route::get('/projects-all', [PortfolioController::class, 'allProjects'])->name('projects.all');
Route::post('/contact', [PortfolioController::class, 'sendContact'])->name('contact.send');

// ─── Auth ──────────────────────────────────────────────────
Route::get('/admin/login', [AuthController::class, 'loginForm'])->name('login'); // Laravel default auth redirect
Route::get('/admin/login', [AuthController::class, 'loginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login']);
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// ─── Admin (Protected) ────────────────────────────────────
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // Profile
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::put('/profile', [AdminController::class, 'updateProfile'])->name('profile.update');

    // Projects
    Route::get('/projects', [AdminController::class, 'projects'])->name('projects');
    Route::get('/projects/create', [AdminController::class, 'createProject'])->name('projects.create');
    Route::post('/projects', [AdminController::class, 'storeProject'])->name('projects.store');
    Route::get('/projects/{project}/edit', [AdminController::class, 'editProject'])->name('projects.edit');
    Route::put('/projects/{project}', [AdminController::class, 'updateProject'])->name('projects.update');
    Route::delete('/projects/{project}', [AdminController::class, 'deleteProject'])->name('projects.delete');

    // Skills
    Route::get('/skills', [AdminController::class, 'skills'])->name('skills');
    Route::post('/skills', [AdminController::class, 'storeSkill'])->name('skills.store');
    Route::put('/skills/{skill}', [AdminController::class, 'updateSkill'])->name('skills.update');
    Route::delete('/skills/{skill}', [AdminController::class, 'deleteSkill'])->name('skills.delete');

    // Experiences
    Route::get('/experiences', [AdminController::class, 'experiences'])->name('experiences');
    Route::post('/experiences', [AdminController::class, 'storeExperience'])->name('experiences.store');
    Route::put('/experiences/{experience}', [AdminController::class, 'updateExperience'])->name('experiences.update');
    Route::delete('/experiences/{experience}', [AdminController::class, 'deleteExperience'])->name('experiences.delete');

    // Contacts
    Route::get('/contacts', [AdminController::class, 'contacts'])->name('contacts');
    Route::patch('/contacts/{contact}/read', [AdminController::class, 'markRead'])->name('contacts.read');
    Route::delete('/contacts/{contact}', [AdminController::class, 'deleteContact'])->name('contacts.delete');
});
