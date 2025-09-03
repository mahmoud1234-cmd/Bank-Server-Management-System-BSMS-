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

    // Servers - routes spécifiques avant resource
    Route::get('/servers/add-to-site', [ServerController::class, 'addToSite'])->name('servers.add-to-site');
    Route::post('/servers/store-to-site', [ServerController::class, 'storeToSite'])->name('servers.store-to-site');
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
        
        if ($servers->isEmpty()) {
            return redirect('/dashboard')->with('error', 'Aucun serveur trouvé. Veuillez créer des serveurs d\'abord.');
        }
        
        return view('incidents.create', compact('servers', 'users'));
    })->name('test.incident.form');
    
    Route::get('/test/cluster-form', function() {
        $availableServers = App\Models\Server::whereNull('cluster_id')->get();
        
        if ($availableServers->isEmpty()) {
            return redirect('/dashboard')->with('error', 'Aucun serveur disponible pour créer un cluster. Tous les serveurs sont déjà assignés.');
        }
        
        return view('clusters.create', compact('availableServers'));
    })->name('test.cluster.form');
    
    Route::get('/test/maintenance-form', function() {
        $servers = App\Models\Server::all();
        $users = App\Models\User::all();
        
        if ($servers->isEmpty()) {
            return redirect('/dashboard')->with('error', 'Aucun serveur trouvé. Veuillez créer des serveurs d\'abord.');
        }
        
        return view('maintenance-tasks.create', compact('servers', 'users'));
    })->name('test.maintenance.form');
});

// Inclut les routes d'auth supplémentaires si présentes
require __DIR__.'/auth.php';
