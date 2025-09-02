<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Foundation\Application;

// Contrôleurs
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DatacenterController;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ClusteringController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\MaintenanceTaskController;

// -----------------------------
// ROUTES PUBLIQUES
// -----------------------------
Route::get('/', function () {
    return redirect()->route('login.form');
});

// Signup
Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup.form');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup');

// Login / Logout
Route::get('/login', [AuthController::class, 'showSigninForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'signin'])->name('login');
Route::post('/logout', [AuthController::class, 'signout'])->name('logout');

// -----------------------------
// ROUTES AUTHENTIFIÉES
// -----------------------------
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // Servers
    Route::resource('servers', ServerController::class);

    // Datacenters
    Route::resource('datacenters', DatacenterController::class);

    // Maintenance tasks
    Route::resource('maintenance-tasks', MaintenanceTaskController::class);

    // Incidents
    Route::resource('incidents', IncidentController::class);

    // Reports & Clustering
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/clustering', [ClusteringController::class, 'index'])->name('clustering.index');
});

// Inclut les routes d'auth supplémentaires si présentes
require __DIR__.'/auth.php';
