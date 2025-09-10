<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TestController extends Controller
{
    public function testApplicationRoute()
    {
        Log::info('Test de la route application/create');
        
        // Vérifier si l'utilisateur est authentifié
        if (!auth()->check()) {
            return response()->json(['error' => 'Non authentifié'], 401);
        }
        
        // Vérifier si l'utilisateur est admin
        if (auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Accès non autorisé'], 403);
        }
        
        return response()->json([
            'status' => 'success',
            'message' => 'La route fonctionne correctement',
            'user' => auth()->user()->only(['id', 'name', 'email', 'role'])
        ]);
    }
}
