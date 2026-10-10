<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projet;
use App\Models\Taches;
use App\Models\User;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use App\Exports\ProjetsExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
class ProjetController extends Controller
{
    public function index()
{
  
    $projets = Projet::with(['taches', 'chefProjet'])
                ->latest()
                ->paginate(40);

    
    
    $clients = Client::all();
    
    $statuts = Projet::select('statut_projet')->distinct()->pluck('statut_projet');
    
 
    $chefsProjet = User::whereHas('projets')->get();


    $nombreProjetsLivre = Projet::where('statut_projet', 'Livré')->count();

    $nombreProjetsEncours = Projet::where('statut_projet', 'En cours')->count();
    $nombreProjetsATraites = Projet::where('statut_projet', 'Attente Info Supp')->count();
    $nombreProjetsTraites = Projet::where('statut_projet', 'Traité')->count();
    $projetTotal = Projet::count();

    return view('projets.index', compact('projets', 'clients', 'statuts', 'chefsProjet', 'nombreProjetsLivre','nombreProjetsEncours','nombreProjetsTraites','nombreProjetsATraites','projetTotal'));
}

public function evolutionMensuelle()
{
    $statsMensuelles = Projet::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as mois, statut_projet, COUNT(*) as total")
        ->groupBy('mois', 'statut_projet')
        ->orderBy('mois')
        ->get();

    // Organiser les données en un format plus facile pour Chart.js
    $moisLabels = $statsMensuelles->pluck('mois')->unique()->values();
    $statuts = $statsMensuelles->pluck('statut_projet')->unique();

    $datasets = [];

    foreach ($statuts as $statut) {
        $data = [];
        foreach ($moisLabels as $mois) {
            $projet = $statsMensuelles->where('mois', $mois)->where('statut_projet', $statut)->first();
            $data[] = $projet ? $projet->total : 0;
        }

        $datasets[] = [
            'label' => $statut,
            'data' => $data,
        ];
    }

    return view('projets.evolution', compact('moisLabels', 'datasets'));
}




    public function mesProjets(Request $request)
    {
        $query = Projet::where('users_id', Auth::id())->with('chefProjet');
        $clients = Client::all();
        $statuts = Projet::select('statut_projet')->distinct()->pluck('statut_projet');
    
        if ($request->filled('client_id')) {
            $query->where('clients_id', $request->client_id);
        }
    
        if ($request->filled('statut')) {
            $query->whereHas('taches', function ($q) use ($request) {
                $q->where('informations->statut_rop', $request->statut);
            });
        }
   
        if ($request->filled('commande_debut')) {
            $query->whereDate('date_commande', '>=', $request->commande_debut);
        }
    
        if ($request->filled('commande_fin')) {
            $query->whereDate('date_commande', '<=', $request->commande_fin);
        }
    
        if ($request->filled('livraison_debut')) {
            $query->whereHas('taches', function ($q) use ($request) {
                $q->whereDate('informations->date_livraison_rop', '>=', $request->livraison_debut);
            });
        }
    
        if ($request->filled('livraison_fin')) {
            $query->whereHas('taches', function ($q) use ($request) {
                $q->whereDate('informations->date_livraison_rop', '<=', $request->livraison_fin);
            });
        }
    
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('reference', 'like', '%' . $request->search . '%')
                  ->orWhere('nom_site', 'like', '%' . $request->search . '%');
            });
        }
    
      
        $projets = $query->orderBy('date_commande', 'desc')->paginate(40)->appends($request->all());

    
        return view('projets.mes-projets', compact('projets', 'statuts', 'clients'));
    }
    

   public function projetsPrestaire(Request $request)
    {
        $user = Auth::user()->load('client');

    if ($user->hasRole('client') && $user->client) {
        $clientId = $user->client->id;
        
        // Initialisation de la requête de base
        $query = Projet::where('clients_id', $clientId);

        // Filtre par mois
        if ($request->has('mois') && $request->mois != '') {
            $query->whereMonth('date_commande', $request->mois);
        }

        // Filtre par année (modifié)
        if ($request->has('annee') && $request->annee != '') {
            $query->whereYear('date_commande', $request->annee);
            $annee = $request->annee;
        } else {
            $annee = null; // Aucun filtre par année
        }

        // Filtre par statut projet
        if ($request->has('statut_projet') && $request->statut_projet != '') {
            $query->where('statut_projet', $request->statut_projet);
        }

      
    
            // Filtre par statut projet
            if ($request->has('statut_projet') && $request->statut_projet != '') {
                $query->where('statut_projet', $request->statut_projet);
            }
    
            // Filtre par date de commande (début)
            if ($request->has('commande_debut') && $request->commande_debut != '') {
                $query->whereDate('date_commande', '>=', $request->commande_debut);
            }
    
            // Filtre par date de commande (fin)
            if ($request->has('commande_fin') && $request->commande_fin != '') {
                $query->whereDate('date_commande', '<=', $request->commande_fin);
            }
    
            // Filtre par date de livraison (début)
            if ($request->has('livraison_debut') && $request->livraison_debut != '') {
                $query->whereDate('date_livraison', '>=', $request->livraison_debut);
            }
    
            // Filtre par date de livraison (fin)
            if ($request->has('livraison_fin') && $request->livraison_fin != '') {
                $query->whereDate('date_livraison', '<=', $request->livraison_fin);
            }
    
            // Filtre par recherche
            if ($request->has('search') && $request->search != '') {
                $query->where(function ($q) use ($request) {
                    $q->where('reference', 'like', '%' . $request->search . '%')
                      ->orWhere('nom_site', 'like', '%' . $request->search . '%');
                });
            }
    
            // Récupération des données
            $projets = $query->with('client')->paginate(40)->appends($request->all());
    
            // Statistiques globales (sans les filtres de pagination)
            $statsQuery = clone $query;
            $totalProjets = $statsQuery->count();
            $projetsLivres = $statsQuery->where('statut_projet', 'LIVRE')->count();
            $projetsTermines = $statsQuery->where('statut_projet', 'Terminé')->count();
            $projetsEnCours = $statsQuery->where('statut_projet', 'EN COURS')->count();
    
            // Données pour le graphique par mois
        
            
            
           
    
            return view('projets.projet-client', [
                'projets' => $projets,
                'client' => $user->client,
                'totalProjets' => $totalProjets,
                'projetsLivres' => $projetsLivres,
                'projetsTermines' => $projetsTermines,
                'projetsEnCours' => $projetsEnCours,

                'statuts' => Projet::select('statut_projet')->distinct()->pluck('statut_projet'),
                'filters' => $request->all() // Pour conserver les filtres dans la vue
            ]);
        }
    
        return redirect()->route('home.index')->with('error', 'Vous n\'êtes pas autorisé à accéder à cette page.');
    }

 
 

    public function edit($id)
    {
        
        $projet = Projet::findOrFail($id);
        $users=User::all();
        $clients = Client::all();
       
        return view('projets.edit', compact('projet','users','clients'));
    }
public function showTaches($projetId)
{
    $user = auth()->user();
    $projet = Projet::with('taches')->findOrFail($projetId);

    // Si c'est un client, il ne peut voir que ses propres projets
    if ($user->hasRole('client')) {
        if ($projet->clients_id !== $user->clients_id) {
            abort(403, 'Accès interdit à ce projet.');
        }
    }

    // Si ce n'est pas un admin, vérifier qu'il a au moins une tâche dans ce projet
     elseif (!$user->hasAnyRole(['admin', 'Manager', 'operation'])) {
        $aAcces = $projet->taches->contains(function ($tache) use ($user) {
            return $tache->users_id === $user->id;
        });

        if (!$aAcces) {
            abort(403, 'Vous n’avez pas accès à ce projet.');
        }
    }

    $taches = $projet->taches;

    return view('projets.tache', compact('projet', 'taches'));
}


    public function create()
    {
        $users = User::all();
        $clients = Client::all();
        return view('projets.create', compact('users','clients'));
    }


   public function store(Request $request)
{
    $messages = [
        'reference.unique' => 'La référence du projet est déjà utilisée. Veuillez en choisir une autre.',
    ];

    $validatedData = $request->validate([
        'reference' => 'required|unique:projets,reference', 
        'clients_id' => 'required|exists:clients,id',
        'nom_site' => 'required',
        'date_commande' => 'required|date',
        'date_livraison'=> 'nullable|date',
        'statut_projet' => 'required',
        'type_projet' => 'nullable|string',
        'commentaires' => 'nullable|string',
        'code_site' => 'nullable|string'
    ], $messages);

    try {
        Projet::create([
            'nom_site' => $validatedData['nom_site'],
            'reference' => $validatedData['reference'],
            'clients_id' => $validatedData['clients_id'],
            'date_commande' => $validatedData['date_commande'],
            'date_livraison' => $validatedData['date_livraison'],
            'users_id' => auth()->id(), // ✅ on force l'utilisateur connecté
            'statut_projet' => $validatedData['statut_projet'],
            'type_projet' => $validatedData['type_projet'],
            'commentaires' => $validatedData['commentaires'],
            'code_site' => $validatedData['code_site']
        ]);

        return redirect()->route('projets.index')->with('success', 'Projet créé avec succès.');

    } catch (\Exception $e) {
        return redirect()->back()->withInput()->with('error', 'Une erreur s\'est produite lors de la création du projet : ' . $e->getMessage());
    }
}


    public function update(Request $request, $id)
    {
        $request->validate([
            'users_id' => 'required|exists:users,id',
            'reference' => 'required|unique:projets,reference,' . $id,
            'clients_id' => 'required',
            'nom_site' => 'required',
            'date_commande' => 'required',
            'date_livraison' => 'nullable',
            'statut_projet' =>'required',
            'type_projet' =>'nullable | string',
            'commentaires' =>'nullable | string',
            'code_site' =>'nullable | string',
            
        ]);
    
        
        $projet = Projet::findOrFail($id);
    
        
        $projet->update([
            'nom_site' => $request->nom_site,
            'reference' => $request->reference,
            'clients_id' => $request->clients_id,
            'date_commande' => $request->date_commande,
            'date_livraison' => $request->date_livraison,
            'users_id' => $request->users_id, 
            'statut_projet'=>$request->statut_projet,
            'type_projet'=>$request->type_projet,
            'commentaires'=>$request->commentaires,
            'code_site'=>$request->code_site,
        ]);
    
        return redirect()->route('projets.index')->with('success', 'Projet mis à jour avec succès.');
    }
    

    public function calculProjet()
{
    
    $projets = Projet::with('taches')->get(); 
    
 
    $nombreProjets = $projets->count();
    
   
    return view('projets.index', compact('projets', 'nombreProjets'));
}

public function destroy($id)
{
    $projet = Projet::findOrFail($id);

    if ($projet->users_id !== auth()->id()) {
        return redirect()->route('projets.index')
            ->with('error', 'Vous n\'êtes pas autorisé à supprimer ce projet.');
    }

    $projet->delete();

    return redirect()->route('projets.index')
        ->with('success', 'Projet supprimé avec succès.');
}





public function filter(Request $request)
{
    $query = Projet::query();

    if ($request->filled('clients_id')) {
        $query->where('clients_id', $request->clients_id);
    }

    if ($request->filled('statut_projet')) {
        $query->where('statut_projet', $request->statut_projet);
    }

    if ($request->filled('date_debut')) {
        $query->whereDate('date_commande', '>=', $request->date_debut);
    }

    if ($request->filled('date_fin')) {
        $query->whereDate('date_commande', '<=', $request->date_fin);
    }

    if ($request->filled('date_debute')) {
        $query->whereDate('date_livraison', '>=', $request->date_debute);
    }

    if ($request->filled('date_fine')) {
        $query->whereDate('date_livraison', '<=', $request->date_fine);
    }

    if ($request->filled('chef_projet_id')) {
        $query->whereHas('chefProjet', function ($q) use ($request) {
            $q->where('id', $request->chef_projet_id);
        });
    }

    
    if ($request->has('export') && $request->export === 'true') {
        return Excel::download(new ProjetsExport($query), 'projets_filtres.xlsx');
    }

    $projets = $query->paginate(40)->appends($request->all());
    $nombreProjetsLivre = $query->clone()->where('statut_projet', 'livré')->count();
    $nombreProjetsEncours = $query->clone()->where('statut_projet', 'en cours')->count();
    $nombreProjetsATraites = $query->clone()->where('statut_projet', 'Attente Info Supp')->count();
    $nombreProjetsTraites = $query->clone()->where('statut_projet', 'traité')->count();
      $projetTotal = Projet::count();
    $clients = Client::all();
    $statuts = Projet::select('statut_projet')->distinct()->pluck('statut_projet');
    $chefsProjet = User::whereHas('projets')->get();

    return view('projets.index', compact(
        'projets',
        'clients',
        'statuts',
        'chefsProjet',
        'nombreProjetsLivre',
        'nombreProjetsEncours',
        'nombreProjetsTraites',
        'nombreProjetsATraites',
        'projetTotal'
    ));
}


public function exportExcel()
{
    // Exporter les projets
    return Excel::download(new ProjetsExport(), 'projets.xlsx');
}

public function search(Request $request)
{
    $query = Projet::query();

    if ($request->filled('search')) {
        $search = trim($request->search);
        $query->where(function ($q) use ($search) {
            $q->where('reference', 'LIKE', "%{$search}%")
              ->orWhere('nom_site', 'LIKE', "%{$search}%");
        });
    }

    // Ajout d'un filtre par statut
    if ($request->filled('statut')) {
        $query->where('statut_projet', $request->statut);
    }

    // Ajout d'un filtre par client (si applicable)
    if ($request->filled('client_id')) {
        $query->where('client_id', $request->client_id);
    }

    // Récupération paginée avec conservation des paramètres de recherche
    $projets = $query->paginate(10)->appends($request->query());

    $clients = Client::all();
    $statuts = Projet::select('statut_projet')->distinct()->pluck('statut_projet');

    // ✅ Compter les projets livrés
    $nombreProjetsLivre = Projet::where('statut_projet', 'livré')->count();
    $nombreProjetsEncours = Projet::where('statut_projet', 'En cours')->count();
    $nombreProjetsATraites = Projet::where('statut_projet', 'A traiter')->count();
    $nombreProjetsTraites = Projet::where('statut_projet', 'Traité')->count();
      $projetTotal = Projet::count();
 $chefsProjet = User::whereHas('projets')->get();
    return view('projets.index', compact('projets','chefsProjet', 'clients', 'statuts', 'nombreProjetsLivre', 'nombreProjetsEncours', 'nombreProjetsATraites','nombreProjetsTraites','projetTotal'));
}



public function show($id)
{
    $user = auth()->user();
    $projet = Projet::with(['taches', 'chefProjet', 'client'])->findOrFail($id);

    // Si c'est un client, il ne peut voir que ses propres projets
    if ($user->hasRole('client')) {
        if ($projet->clients_id !== $user->clients_id) {
            abort(403, 'Accès interdit à ce projet.');
        }
    }

    // Si c'est un autre utilisateur, il ne peut voir que les projets où il a une tâche
     elseif (!$user->hasAnyRole(['admin', 'Manager', 'operation'])) {
        $aAcces = $projet->taches->contains(function ($tache) use ($user) {
            return $tache->users_id === $user->id;
        });

        if (!$aAcces) {
            abort(403, 'Vous n’avez pas accès à ce projet.');
        }
    }

    return view('projets.vue', compact('projet'));
}

public function bulkUpdateStatus(Request $request)
{
    $request->validate([
        'selected_ids' => 'required|array',
        'new_status' => 'required|string',
    ]);

    $now = Carbon::now();

    Projet::whereIn('id', $request->selected_ids)
        ->get()
        ->each(function ($projet) use ($request, $now) {
            $data = ['statut_projet' => $request->new_status];

            // Si le nouveau statut est "Livré" et que ce n'était pas déjà le cas → on met la date
            if ($request->new_status === 'Livré' && $projet->statut_projet !== 'Livré') {
                $data['date_livraison'] = $now;
            }

            // Si on repasse sur autre chose que "Livré" → on enlève la date (optionnel)
            if ($request->new_status !== 'Livré') {
                $data['date_livraison'] = null;
            }

            $projet->update($data);
        });

    return redirect()->back()->with('success', 'Statut mis à jour pour les projets sélectionnés.');
}



}
