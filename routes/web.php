<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Foundation\Application;

// Contrôleurs
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DatacenterController;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ClusterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\MaintenanceTaskController;

// -----------------------------
// ROUTES PUBLIQUES
// -----------------------------
// Route d'accueil - redirection vers login ou dashboard
Route::get('/', function () {
    return auth()->check() ? redirect('/dashboard') : redirect('/login');
})->name('home');

// Les routes d'authentification sont gérées par auth.php (Laravel Breeze)

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

    // Clusters
    Route::resource('clusters', ClusterController::class);

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    
    // Routes de test pour diagnostic
    Route::get('/test/incident-form', function() {
        $servers = App\Models\Server::all();
        $users = App\Models\User::all();
        return view('incidents.create', compact('servers', 'users'));
    })->name('test.incident.form');
    
    Route::get('/test/cluster-form', function() {
        $availableServers = App\Models\Server::whereNull('cluster_id')->get();
        return view('clusters.create', compact('availableServers'));
    })->name('test.cluster.form');
});

// Inclut les routes d'auth supplémentaires si présentes
require __DIR__.'/auth.php';
