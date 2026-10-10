<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projet;
use App\Models\Taches;
use App\Models\Client;
use App\Models\TypeTache;
class BloController extends Controller
{
    public function afficheBloNexloop(Request $request)
{
    $user = auth()->user();

    $query = Projet::query()->with(['taches.typeTache', 'client'])
        ->whereHas('client', function ($q) {
            $q->where('nom', 'NEXLOOP');
        })
        ->whereHas('taches', function ($q) {
            $q->whereHas('typeTache', function ($q) {
                $q->where('nom', 'BLO');
            });
        });

    // filtre statut
    if ($request->filled('statut')) {
        $query->whereHas('taches', function ($q) use ($request) {
            $q->where('informations->statut_blo', $request->statut);
        });
    }

    // filtre date début
    if ($request->filled('date_debut')) {
        $query->whereHas('taches', function ($q) use ($request) {
            $q->whereDate('informations->date_livraison_rop', '>=', $request->date_debut);
        });
    }

    // filtre date fin
    if ($request->filled('date_fin')) {
        $query->whereHas('taches', function ($q) use ($request) {
            $q->whereDate('informations->date_livraison_rop', '<=', $request->date_fin);
        });
    }

    // recherche
    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('reference', 'like', '%' . $request->search . '%')
              ->orWhere('nom_site', 'like', '%' . $request->search . '%');
        });
    }

    $projets = $query->paginate(60)->appends($request->all());

    return view('nexloop.blo.index', compact('projets'));
}


public function afficheBloMcConnect(Request $request)
{
    $user = auth()->user();

    $query = Projet::query()->with(['taches.typeTache', 'client'])
        ->whereHas('client', function ($q) {
            $q->where('nom', 'MCONNECTIC');
        })
        ->whereHas('taches', function ($q) {
            $q->whereHas('typeTache', function ($q) {
                $q->where('nom', 'BLO');
            });
        });

    // filtre statut
    if ($request->filled('statut')) {
        $query->whereHas('taches', function ($q) use ($request) {
            $q->where('informations->statut_blo', $request->statut);
        });
    }

    // filtre date début
    if ($request->filled('date_debut')) {
        $query->whereHas('taches', function ($q) use ($request) {
            $q->whereDate('informations->date_livraison_rop', '>=', $request->date_debut);
        });
    }

    // filtre date fin
    if ($request->filled('date_fin')) {
        $query->whereHas('taches', function ($q) use ($request) {
            $q->whereDate('informations->date_livraison_rop', '<=', $request->date_fin);
        });
    }

    // recherche
    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('reference', 'like', '%' . $request->search . '%')
              ->orWhere('nom_site', 'like', '%' . $request->search . '%');
        });
    }

    $projets = $query->paginate(60)->appends($request->all());

    return view('McConnect.index', compact('projets'));
}
}