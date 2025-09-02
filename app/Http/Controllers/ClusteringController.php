<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class ClusteringController extends Controller
{
    public function index()
    {
        // Ici tu peux envoyer des données à la vue
        return Inertia::render('Clustering/Index', [
            'title' => 'Clustering Dashboard',
            'description' => 'Visualisation et gestion du clustering des serveurs',
        ]);
    }
}
