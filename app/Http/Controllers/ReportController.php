<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Incident;
use Illuminate\Support\Facades\DB;
use App\Models\Server;


class ReportController extends Controller
{
    // Page principale des rapports
    public function index()
{
    $servers = Server::all();        // pour le tableau des serveurs
    $incidents = Incident::all();    // pour le tableau des incidents

    // statistiques incidents
    $totalIncidents = $incidents->count();
    $statusStats = $incidents->groupBy('status')->map->count();
    $severityStats = $incidents->groupBy('severity')->map->count();
    $categoryStats = $incidents->groupBy('category')->map->count();
    $avgResolutionTime = $incidents->whereNotNull('resolved_at')
        ->avg(function($i) {
            return \Carbon\Carbon::parse($i->detected_at)
                ->diffInHours(\Carbon\Carbon::parse($i->resolved_at));
        });

    return view('reports.index', compact(
        'servers',
        'incidents',               // <-- ajouter ici
        'totalIncidents',
        'statusStats',
        'severityStats',
        'categoryStats',
        'avgResolutionTime'
    ));
}


    // Rapport sur les serveurs
 public function servers()
{
    $servers = Server::all();           // récupère tous les serveurs
    $incidents = Incident::all();       // récupère tous les incidents (optionnel)

    return view('reports.servers', compact('servers', 'incidents'));
}


    // Rapport sur les incidents
    public function incidents()
    {
        return view('reports.incidents');
    }

    // Rapport sur la maintenance
    public function maintenance()
    {
        return view('reports.maintenance');
    }

    // Rapport d’audit
    public function audit()
    {
        return view('reports.audit');
    }

    // Export CSV / PDF
    public function export($type)
    {
        if ($type === 'csv') {
            // logique d'export CSV
        } elseif ($type === 'pdf') {
            // logique d'export PDF
        }

        return back()->with('success', "Export $type effectué avec succès !");
    }
}
