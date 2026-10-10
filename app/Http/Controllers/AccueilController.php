<?php

namespace App\Http\Controllers;
use App\Models\Projet;
use Illuminate\Http\Request;

class AccueilController extends Controller
{
    public function index(Request $request)
{
    $user = auth()->user();

    $query = Projet::query()->with(['taches' => function ($q) {
        $q->whereHas('typeTache', function ($q) {
            $q->where('nom', 'ROP');
        });
    }]);

    // Filtrage par rôle
    if ($user->hasRole('client')) {
        $query->where('clients_id', $user->clients_id);
    } elseif (!$user->hasAnyRole(['admin', 'client'])) {
        $query->whereHas('taches', function ($q) use ($user) {
            $q->where('users_id', $user->id);
        });
    }

    $projets = $query->get();
    $stats['attente_info_sup'] = $projets->where('statut_projet', 'Attente Info Supp')->count();
 

    // Regrouper les projets par statut ROP
    $statuts = ['Attente Info Supp', 'Attente Validation Syno', 'Livré']; // adapte selon ta logique
    $stats = [];

    foreach ($statuts as $statut) {
        $stats[$statut] = $projets->filter(function ($projet) use ($statut) {
            return $projet->taches->contains(function ($tache) use ($statut) {
                return data_get($tache->informations, 'statut_rop') === $statut;
            });
        })->count();
    }

    $stats['total'] = $projets->count();
$stats['attente_info_sup'] = $projets->where('statut_projet', 'Attente Info Supp')->count(); 
    return view('home.accueil', compact('stats'));
}
}
