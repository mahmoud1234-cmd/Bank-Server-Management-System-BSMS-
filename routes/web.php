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
use App\Http\Controllers\Auth\PasswordResetController;

// -----------------------------
// ROUTES PUBLIQUES
// -----------------------------
// Route d'accueil - redirection vers login ou dashboard
Route::get('/', function () {
    return auth()->check() ? redirect('/dashboard') : redirect('/login');
})->name('home');

// Les routes d'authentification sont gérées par auth.php (Laravel Breeze)

// -----------------------------
// ROUTES DE RÉCUPÉRATION DE MOT DE PASSE
// -----------------------------
Route::get('/forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');

// -----------------------------
// ROUTES AUTHENTIFIÉES
// -----------------------------
Route::middleware('auth')->group(function () {

    // Dashboard - accessible à tous les utilisateurs authentifiés
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Routes accessibles uniquement par l'admin et le manager
    Route::middleware(['role:admin,manager'])->group(function () {
        // Gestion des datacenters
        Route::resource('datacenters', DatacenterController::class);
        
        // Gestion des clusters
        Route::resource('clusters', ClusterController::class);
        
        // Gestion des utilisateurs
        Route::get('/users', [ProfileController::class, 'index'])->name('users.index');
        Route::delete('/users/{user}', [ProfileController::class, 'destroy'])->name('users.destroy');
        
        // Rapports
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
    });
    
    // Routes accessibles par l'admin, le manager et le technicien
    Route::middleware(['role:admin,manager,technician'])->group(function () {
        // Gestion des serveurs
        Route::resource('servers', ServerController::class);
        
        // Gestion des incidents
        Route::resource('incidents', IncidentController::class);
        
        // Gestion des maintenances
        Route::resource('maintenance-tasks', MaintenanceTaskController::class);
    });
    
    // Profil utilisateur - accessible à tous les utilisateurs authentifiés
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Profile
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // -----------------------------
    // ROUTES RÉSERVÉES AUX ADMINISTRATEURS
    // -----------------------------
    Route::middleware('admin')->group(function () {
        // Gestion des serveurs (création, modification, suppression)
        Route::get('/servers/add-to-site', [ServerController::class, 'addToSite'])->name('servers.add-to-site');
        Route::post('/servers/store-to-site', [ServerController::class, 'storeToSite'])->name('servers.store-to-site');
        Route::get('/servers/create', [ServerController::class, 'create'])->name('servers.create');
        Route::post('/servers', [ServerController::class, 'store'])->name('servers.store');
        Route::get('/servers/{server}/edit', [ServerController::class, 'edit'])->name('servers.edit');
        Route::put('/servers/{server}', [ServerController::class, 'update'])->name('servers.update');
        Route::delete('/servers/{server}', [ServerController::class, 'destroy'])->name('servers.destroy');
        Route::delete('/servers/{server}/force-destroy', [ServerController::class, 'forceDestroy'])->name('servers.force-destroy');
        
        // Gestion des datacenters (accès complet)
        Route::resource('datacenters', DatacenterController::class);
        
        // Gestion des clusters (accès complet)
        Route::resource('clusters', ClusterController::class);
    });

    // -----------------------------
    // ROUTES POUR TOUS LES UTILISATEURS AUTHENTIFIÉS
    // -----------------------------
    // Consultation des serveurs (lecture seule pour non-admins)
    Route::get('/servers', [ServerController::class, 'index'])->name('servers.index');
    Route::get('/servers/{server}', [ServerController::class, 'show'])->name('servers.show');
    
    // Actions techniques sur les serveurs (disponibles pour tous)
    Route::post('/servers/{server}/test-connection', [ServerController::class, 'testConnection'])->name('servers.test-connection');
    Route::get('/servers/{server}/connect', [ServerController::class, 'connect'])->name('servers.connect');
    Route::post('/servers/{server}/pause', [ServerController::class, 'pause'])->name('servers.pause');
    Route::post('/servers/{server}/resume', [ServerController::class, 'resume'])->name('servers.resume');
    Route::get('/servers/{server}/content', [ServerController::class, 'getContent'])->name('servers.content');

    // Tâches de maintenance (tous peuvent créer et voir)
    Route::resource('maintenance-tasks', MaintenanceTaskController::class);

    // Incidents (tous peuvent créer et voir)
    Route::resource('incidents', IncidentController::class);

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
