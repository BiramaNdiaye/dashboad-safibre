<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projet;
use App\Models\Taches;
use App\Models\Client;
use App\Models\TypeTache;
use App\Exports\ProjetsRopExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Exports\DoeExport;
use App\Models\User;
use App\Exports\RopParOperateurExport;
use App\Exports\RopGraphExport;
class TachesController extends Controller
{
    public function show($id)
{
   
    $projet = Projet::with('taches.typeTache')->findOrFail($id);
    $taches = $projet->taches()->with('typeTache')->get();
    return view('projets.show', compact('projet'));
}

public function index($id)
{
    // $id est la référence du projet
    $projet = Projet::where('reference', $id)->firstOrFail();

    // Récupérer les tâches avec leurs types
    $taches = $projet->taches()->with('typeTache')->get();
 
    // Extraire les versions ROP uniques
    $versionsRop = $taches->pluck('informations.version_rop')->unique();

    // Vérifier s’il y a plus d’une version
    if ($versionsRop->count() <= 1) {
        return redirect()->back()->with('message', 'Ce projet ne contient qu\'une seule version ROP.');
    }

    return view('taches.index', compact('projet', 'taches', 'versionsRop','nombreProjets'));
}


   
    public function create($projetId)
    {
        
        $projet = Projet::findOrFail($projetId);
        $typesTache = ['ROP', 'BLO', 'DOE OPTIQUE' ,'Accompagnement','APD GC/DOE GC'];

        
        $statutsRop = ['En cours', 'Livré','Attente Info Supp','Attente Validation Syno','Attente Validation Lien résilié','Cable Saturé','Pop Saturé','BPE Sensible'];
        
        return view('taches.create', compact('projet'));
    }
   public function store(Request $request)
{
    // 🔹 1. Validation des champs
    $validated = $request->validate([
        'projet_reference' => 'required|exists:projets,reference',
        'type_tache' => 'required|string|in:ROP,BLO,DOE OPTIQUE,Accompagnement,APD GC/DOE GC, PATATOIDE',
        'informations' => 'required|array',

        // Champs ROP
        'informations.type_rop' => 'nullable|string',
        'informations.version_rop' => 'nullable|string',
        'informations.nbre_bpe' => 'nullable|integer',
        'informations.capacite' => ['nullable', 'regex:/^\d+([.,]\d{1,2})?$/'],
        'informations.liste_bpe' => ['nullable', 'string'],
        'informations.statut_rop' => 'nullable|string',
        'informations.statut_rop_netgeo' => 'nullable|string',
        
        'informations.moment_annulation' => 'nullable|string',
        'informations.date_livraison_rop' => 'nullable|date',
        'informations.lien_resilie' => 'nullable|string',
        'informations.com_rop' => 'nullable|string',
        'informations.fichier_zip' => 'nullable|file|mimes:zip|max:10240',

        // Champs BLO
        'informations.type_blo' => 'nullable|string',
        'informations.date_livraison_blo' => 'nullable|date',
        'informations.num_fci' => 'nullable|string',
        'informations.statut_blo' => 'nullable|string',

        // Champs DOE
        'informations.date_demande_doe' => 'nullable|date',
        'informations.support' => 'nullable|string',
        'informations.date_integration' => 'nullable|date',
        'informations.statut_doe' => 'nullable|string',
        'informations.rectification' => 'nullable|string',
        'informations.doe_bpe' => 'nullable|integer',
        'informations.doe_lien' => 'nullable|string',
        'informations.doe_com' => 'nullable|string',

        // Champs Accompagnement
        'informations.type_projet_acc' => 'nullable|string',
        'informations.date_depot' => 'nullable|date',
        'informations.num_ticket' => 'nullable|string',
        'informations.acc_com' => 'nullable|string',

        // Champs APD GC / DOE GC
        'informations.type_prod' => 'nullable|string',
        'informations.date_demande_prod' => 'nullable|date',
        'informations.date_livraison_prod' => 'nullable|date',
        'informations.lineaire' => 'nullable|decimal:0,2',
        'informations.adresse' => 'nullable|string',
        'informations.code_postal' => 'nullable|string',
        'informations.ville' => 'nullable|string',
        'informations.coordonnee' => 'nullable|string',

        // Champs Patatoide
        'informations.type_projet_patatoide' => 'nullable|string',
        'informations.date_reception_patatoide' => 'nullable|date',
        'informations.nbre_bpe_patatoide' => 'nullable|integer',
        'informations.nbre_client_patatoide' => 'nullable|integer',
        'informations.nbre_cable_ext_patatoide' => 'nullable|integer',
        'informations.nbre_racco_client_patatoide' => 'nullable|integer',
        'informations.statut_patatoide' => 'nullable|string',
        'informations.date_liv_patatoide' => 'nullable|date',
        'informations.validation_covage' => 'nullable|string',
        'informations.commentaires_patatoide' => 'nullable|string',
    ], [
        'informations.liste_bpe.regex' => 'Le format des BPE doit être "BPE-XX-XXX-XXX|BPE-XX-XXX-XXX".'
    ]);

    // 🔹 2. Rendre obligatoire la date si statut ROP = Livré/Livrée
    $statut = strtolower($validated['informations']['statut_rop'] ?? '');

    if (
        in_array($statut, ['livré', 'livrée']) &&
        empty($validated['informations']['date_livraison_rop'])
    ) {
        return back()->withInput()->withErrors([
            'informations.date_livraison_rop' => "La date de livraison ROP est obligatoire lorsque le statut est Livré."
        ]);
    }

    // 🔹 3. Nettoyage du champ liste_bpe
    if (!empty($validated['informations']['liste_bpe'])) {
        $validated['informations']['liste_bpe'] = preg_replace('/\s*\|\s*/', ';', $validated['informations']['liste_bpe']);
    }

    if (!empty($validated['informations']['capacite'])) {
    $validated['informations']['capacite'] = number_format(
        (float) str_replace(',', '.', $validated['informations']['capacite']),
        2,
        '.',
        ''
    );
}

    // 🔹 4. Récupération du projet
    $projet = Projet::where('reference', $validated['projet_reference'])->firstOrFail();

    // 🔹 5. Création de la tâche
    $tache = new Taches();
    $tache->projet_reference = $validated['projet_reference'];
    $tache->type_taches_id = $this->getTypeTacheId($validated['type_tache']);

    // 🔹 6. Gestion du fichier joint
    if ($request->hasFile('fichier')) {
        $file = $request->file('fichier');
        $fileName = time() . '_' . $file->getClientOriginalName();

        $folder = strtolower($validated['type_tache']);
        $path = $file->storeAs("uploads/{$folder}", $fileName, 'public');

        $tache->fichier = $path;
    } else {
        $tache->fichier = null;
    }

    // 🔹 7. Vérification des versions ROP
    if ($validated['type_tache'] === 'ROP') {
        $version = $validated['informations']['version_rop'] ?? null;

        if ($version) {
            // Vérifier si version existe déjà
            $existsSameVersion = Taches::where('projet_reference', $validated['projet_reference'])
                ->whereHas('typeTache', fn($q) => $q->where('nom', 'ROP'))
                ->where('informations->version_rop', $version)
                ->exists();

            if ($existsSameVersion) {
                return back()->withInput()->withErrors([
                    'informations.version_rop' => "Une tâche ROP avec la version {$version} existe déjà."
                ]);
            }

            // Vérifier que version précédente existe
            if (preg_match('/V\d+/i', $version)) {
                $numVersion = (int) substr(strtoupper($version), 1);
                if ($numVersion > 1) {
                    $prevVersion = 'V' . ($numVersion - 1);

                    $existsPrev = Taches::where('projet_reference', $validated['projet_reference'])
                        ->whereHas('typeTache', fn($q) => $q->where('nom', 'ROP'))
                        ->where('informations->version_rop', $prevVersion)
                        ->exists();

                    if (!$existsPrev) {
                        return back()->withInput()->withErrors([
                            'informations.version_rop' => "Impossible de créer {$version} : la version {$prevVersion} n'existe pas."
                        ]);
                    }
                }
            }
        }
    }

    // 🔹 8. Enregistrer la tâche
    $tache->informations = $validated['informations'];
    $tache->save();

    // 🔹 9. Redirection
    return redirect()->route('projets.taches.index', ['projet' => $projet->id])
        ->with('success', 'Tâche créée avec succès.');
}


    
    protected function getTypeTacheId($typeTacheName)
    {
       
        $typeTache = TypeTache::where('nom', $typeTacheName)->first();
    
        if ($typeTache) {
            return $typeTache->id;
        }
    
        return null; 
    }
    
    public function edit($id)
    {
        // Trouver la tâche par son ID
        $tache = Taches::findOrFail($id);
    
        // Récupérer le projet lié à la tâche
        $projet = Projet::where('reference', $tache->projet_reference)->firstOrFail();
    
        // Retourner la vue avec la tâche et le projet
        return view('taches.edit', compact('tache', 'projet'));
    }
     
     public function update(Request $request, $id)
{
    // Règles de validation de base
    $rules = [
        'projet_reference' => 'required|exists:projets,reference',
        'type_tache' => 'required|string|in:ROP,BLO,DOE OPTIQUE,Accompagnement,APD GC/DOE GC',
        'informations' => 'required|array',
    ];

    // Validation conditionnelle en fonction du type de tâche
    switch ($request->type_tache) {

        case 'ROP':
            $rules['informations.type_rop'] = 'nullable|string|in:simple,Complexe';
            $rules['informations.version_rop'] = 'nullable|string';
            $rules['informations.moment_annulation'] = 'nullable|string';
            $rules['informations.nbre_bpe'] = 'nullable|integer';
            $rules['informations.capacite'] = ['nullable', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'];
            $rules['informations.liste_bpe'] = 'nullable|string';
            
            $rules['informations.statut_rop'] = 'nullable|string';
            $rules['informations.statut_rop_netgeo'] = 'nullable|string';
            $rules['informations.date_livraison_rop'] = 'nullable|date';
            $rules['informations.lien_resilie'] = 'nullable|string|in:Oui,Non';
            $rules['informations.com_rop'] = 'nullable|string';
        break;

        case 'BLO':
            $rules['informations.type_blo'] = 'nullable|string|in:simple,Complexe';
            $rules['informations.num_fci'] = 'nullable|string';
            $rules['informations.date_livraison_blo'] = 'nullable|date';
            $rules['informations.statut_blo'] = 'nullable|string';
            $rules['informations.version_rop'] = 'nullable|string';
        break;

        case 'DOE OPTIQUE':
            $rules['informations.date_demande_doe'] = 'nullable|date';
            $rules['informations.support'] = 'nullable|string|in:Avec hotline,Sans hotline';
            $rules['informations.date_integration'] = 'nullable|date';
            $rules['informations.statut_doe'] = 'nullable|string';
            $rules['informations.rectification'] = 'nullable|string';
            $rules['informations.doe_bpe'] = 'nullable|integer';
            $rules['informations.doe_lien'] = 'nullable|string';
            $rules['informations.doe_com'] = 'nullable|string';
        break;

        case 'Accompagnement':
            $rules['informations.type_projet_acc'] = 'required|string';
            $rules['informations.date_depot'] = 'nullable|date';
            $rules['informations.num_ticket'] = 'nullable|string|max:255';
        break;

        case 'APD GC/DOE GC':
            $rules['informations.type_prod'] = 'required|string';
            $rules['informations.date_demande_prod'] = 'nullable|date';
            $rules['informations.date_livraison_prod'] = 'nullable|date';
            $rules['informations.lineaire'] = 'nullable|decimal:0,2';
            $rules['informations.adresse'] = 'nullable|string';
            $rules['informations.code_postal'] = 'nullable|string';
            $rules['informations.ville'] = 'nullable|string';
            $rules['informations.coordonnee'] = 'nullable|string';
        break;

        default:
            return redirect()->back()->with('error', 'Type de tâche non valide.');
    }

    // 🔹 Validation des règles
    $validated = $request->validate($rules);

    // 🔹 Condition ROP : statut Livré → date obligatoire
    if ($validated['type_tache'] === 'ROP') {
        $statut = strtolower($validated['informations']['statut_rop'] ?? '');

        if (
            in_array($statut, ['livré', 'livree', 'livrée', 'livre']) && 
            empty($validated['informations']['date_livraison_rop'])
        ) {
            return back()->withInput()->withErrors([
                'informations.date_livraison_rop' => "La date de livraison ROP est obligatoire lorsque le statut est Livré."
            ]);
        }
    }

    // 🔹 Récupération de la tâche
    $tache = Taches::findOrFail($id);

    // 🔹 Récupération du projet
    $projet = Projet::where('reference', $validated['projet_reference'])->firstOrFail();

    // 🔹 Mise à jour
    $tache->projet_reference = $validated['projet_reference'];
    $tache->type_taches_id = $this->getTypeTacheId($validated['type_tache']);
    $tache->informations = $validated['informations'];
    $tache->save();

    // 🔹 Redirection
    return redirect()->route('projets.taches.index', ['projet' => $projet->id])
        ->with('success', 'Tâche mise à jour avec succès.');
}


public function afficheRop(Request $request)
{
    $query = Projet::query()->with('taches', 'taches.typeTache')->latest();
    $clients = Client::all();
    $user = auth()->user();

    // Filtrage selon le rôle
    switch (true) {
        case $user->hasRole('client'):
            $query->where('clients_id', $user->clients_id);
            break;
            
        case !$user->hasAnyRole(['admin', 'client', 'Manager']):
            $query->whereHas('taches', function ($q) use ($user) {
                $q->where('users_id', $user->id);
            });
            break;
    }

    // Appliquer les filtres globaux (dates, client, search, etc.)
    $this->applyFilters($query, $request);

    // Garder uniquement les projets avec des tâches ROP
    $query->whereHas('taches.typeTache', function ($q) use ($request) {
        $q->where('nom', 'ROP');
        
        // Ajouter les filtres de date pour les tâches ROP
        if ($request->filled('livraison_debut')) {
            $q->whereDate('informations->date_livraison_rop', '>=', $request->livraison_debut);
        }
        if ($request->filled('livraison_fin')) {
            $q->whereDate('informations->date_livraison_rop', '<=', $request->livraison_fin);
        }
    });

    // Récupérer les projets filtrés
    $projets = $query->paginate(40)->appends($request->all());

    // === COMPTEURS (après filtres projet+tâches) ===
    $tachesRopFiltrees = Taches::whereHas('typeTache', fn($t) => $t->where('nom', 'ROP'))
        ->whereHas('projet', function ($q) use ($request, $user) {
            // Logique projet
            switch (true) {
                case $user->hasRole('client'):
                    $q->where('clients_id', $user->clients_id);
                    break;
                case !$user->hasAnyRole(['admin', 'Manager', 'client']):
                    $q->whereHas('taches', fn($q2) => $q2->where('users_id', $user->id));
                    break;
            }
            $this->applyFilters($q, $request);
        })
        ->when($request->filled('livraison_debut'), fn($q) => 
            $q->whereDate('informations->date_livraison_rop', '>=', $request->livraison_debut)
        )
        ->when($request->filled('livraison_fin'), fn($q) => 
            $q->whereDate('informations->date_livraison_rop', '<=', $request->livraison_fin)
        );

    $nombreRop = (clone $tachesRopFiltrees)->count();
    $nombreAttenteInfoSupp = (clone $tachesRopFiltrees)
        ->where('informations->statut_rop', 'Attente Info Supp')
        ->count();
    $nombreAttenteValidationSyno = (clone $tachesRopFiltrees)
        ->where('informations->statut_rop', 'Attente Validation Syno')
        ->count();
    $nombreCableSature = (clone $tachesRopFiltrees)
        ->where('informations->statut_rop', 'En cours')
        ->count();
    $nombreRopLivrees = (clone $tachesRopFiltrees)
        ->where('informations->statut_rop', 'Livré')
        ->count();
    $nombreRopLivreesParProjet = (clone $tachesRopFiltrees)
        ->where('informations->statut_rop', 'Livré')
        ->select('projet_reference')
        ->distinct()
        ->count();

    return view('corbeille-rop.index', compact(
        'projets',
        'clients',
        'nombreRop',
        'nombreAttenteInfoSupp',
        'nombreAttenteValidationSyno',
        'nombreCableSature',
        'nombreRopLivrees',
        'nombreRopLivreesParProjet'
    ));
}





    
    
    public function afficheBlo(Request $request)
{
    $user = auth()->user();
    $query = Projet::query()->with(['taches.typeTache', 'client'])->latest(); // Optimisation du chargement des relations
    
    // Filtrage par rôle
    if ($user->hasRole('client')) {
        // Client voit uniquement ses propres projets avec tâches ROP
        $query->where('clients_id', $user->clients_id)
              ->whereHas('taches', function($q) {
                  $q->whereHas('typeTache', function($q) {
                      $q->where('nom', 'ROP');
                  });
              });
    } elseif (!$user->hasRole('admin')) {
        // Utilisateur normal voit uniquement ses tâches ROP
        $query->whereHas('taches', function($q) use ($user) {
            $q->where('users_id', $user->id)
              ->whereHas('typeTache', function($q) {
                  $q->where('nom', 'ROP');
              });
        });
    } else {
        // Admin voit tout mais uniquement les projets avec tâches ROP
        $query->whereHas('taches', function($q) {
            $q->whereHas('typeTache', function($q) {
                $q->where('nom', 'ROP');
            });
        });
    }

    // Filtres supplémentaires
    if ($request->filled('statut')) {
        $query->whereHas('taches', function($q) use ($request) {
            $q->where('informations->statut_blo', $request->statut);
        });
    }

     if ($request->filled('clients_id')) {
        $query->where('clients_id', $request->clients_id);
    }


        
    if ($request->filled('date_debut')) {
        $query->whereHas('taches', function($q) use ($request) {
            $q->whereDate('informations->date_livraison_rop', '>=', $request->date_debut);
        });
    }

    if ($request->filled('date_fin')) {
        $query->whereHas('taches', function($q) use ($request) {
            $q->whereDate('informations->date_livraison_rop', '<=', $request->date_fin);
        });
    }

    if ($request->filled('search')) {
        $query->where(function($q) use ($request) {
            $q->where('reference', 'like', '%'.$request->search.'%')
              ->orWhere('nom_site', 'like', '%'.$request->search.'%')
              ->orWhereHas('client', function($q) use ($request) {
                  $q->where('nom', 'like', '%'.$request->search.'%');
              });
        });
    }

    $projets = $query->paginate(60)->appends($request->all());
    $clients = Client::all(); // Pour les filtres éventuels

    return view('corbeille-blo.index', compact('projets', 'clients'));
}

public function listeAccompagnements(Request $request)
{
    $user = auth()->user();
    $query = Projet::query()->with(['taches.typeTache', 'client'])->latest(); 
    
    
    if ($user->hasRole('client')) {
       
        $query->where('clients_id', $user->clients_id)
              ->whereHas('taches', function($q) {
                  $q->whereHas('typeTache', function($q) {
                      $q->where('nom', 'Accompagnement');
                  });
              });
    } elseif (!$user->hasRole('admin')) {
        // Utilisateur normal voit uniquement ses tâches ROP
        $query->whereHas('taches', function($q) use ($user) {
            $q->where('users_id', $user->id)
              ->whereHas('typeTache', function($q) {
                  $q->where('nom', 'Accompagnement');
              });
        });
    } else {
        // Admin voit tout mais uniquement les projets avec tâches ROP
        $query->whereHas('taches', function($q) {
            $q->whereHas('typeTache', function($q) {
                $q->where('nom', 'Accompagnement');
            });
        });
    }
    // Filtrer par référence ou numéro de ticket dans un seul champ
    if ($request->filled('search')) {
        $query->where(function($q) use ($request) {
            $q->where('reference', 'like', '%'.$request->search.'%')
              ->orWhere('nom_site', 'like', '%'.$request->search.'%')
              ->orWhereHas('client', function($q) use ($request) {
                  $q->where('nom', 'like', '%'.$request->search.'%');
              });
        });
    }
    // Récupération des projets avec les tâches et types de tâches
    $projets = $query->with('taches', 'taches.typeTache')->paginate(40);
    $clients = Client::all();
    return view('accompagnements.index', compact('projets', 'clients'));
}




public function listeDOE(Request $request)
{
    $user = auth()->user();

    // Base query : projets contenant au moins une tâche DOE OPTIQUE
    $query = Projet::query()->whereHas('taches', function ($q) {
        $q->whereHas('typeTache', fn($t) => $t->where('nom', 'DOE OPTIQUE'));
    });

    // -----------------------------------------
    // Filtrage par rôle
    // -----------------------------------------
    if ($user->hasRole('client')) {
        // Le client ne voit que SES projets DOE
        $query->where('clients_id', $user->clients_id);
    } elseif (!$user->hasRole('admin')) {
        // L'utilisateur standard ne voit que SES tâches DOE
        $query->whereHas('taches', function ($q) use ($user) {
            $q->where('users_id', $user->id)
              ->whereHas('typeTache', fn($t) => $t->where('nom', 'DOE OPTIQUE'));
        });
    }

    // -----------------------------------------
    // Filtre client via dropdown
    // -----------------------------------------
    if ($request->filled('clients_id')) {
        $query->where('clients_id', $request->clients_id);
    }

    // -----------------------------------------
    // Recherche multi-champs
    // -----------------------------------------
    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('reference', 'like', '%' . $request->search . '%')
              ->orWhere('nom_site', 'like', '%' . $request->search . '%')
              ->orWhereHas('client', fn($c) => $c->where('nom', 'like', '%' . $request->search . '%'));
        });
    }

    // -----------------------------------------
    // Filtre SUPPORT (dans JSON informations)
    // -----------------------------------------
    if ($request->filled('support')) {
        $query->whereHas('taches', function ($q) use ($request) {
            $q->whereHas('typeTache', fn($t) => $t->where('nom', 'DOE OPTIQUE'))
              ->whereRaw('json_unquote(json_extract(informations, "$.\"support\"")) = ?', [$request->support]);
        });
    }

    // -----------------------------------------
    // Filtre STATUT DOE (dans JSON informations)
    // -----------------------------------------
    if ($request->filled('statut_doe')) {
        $query->whereHas('taches', function ($q) use ($request) {
            $q->whereHas('typeTache', fn($t) => $t->where('nom', 'DOE OPTIQUE'))
              ->whereRaw('json_unquote(json_extract(informations, "$.\"statut_doe\"")) = ?', [$request->statut_doe]);
        });
    }

    // -----------------------------------------
    // Filtre DATE D’INTÉGRATION (début + fin) dans JSON informations
    // -----------------------------------------
    if ($request->filled('date_integration_debut') || $request->filled('date_integration_fin')) {
        $query->whereHas('taches', function ($q) use ($request) {
            $q->whereHas('typeTache', fn($t) => $t->where('nom', 'DOE OPTIQUE'));

            if ($request->filled('date_integration_debut')) {
                $q->whereRaw('date(json_unquote(json_extract(informations, "$.\"date_integration\""))) >= ?', [$request->date_integration_debut]);
            }
            if ($request->filled('date_integration_fin')) {
                $q->whereRaw('date(json_unquote(json_extract(informations, "$.\"date_integration\""))) <= ?', [$request->date_integration_fin]);
            }
        });
    }

    // -----------------------------------------
    // Chargement des relations
    // -----------------------------------------
    $projets = $query->with([
        'client',
        'taches' => fn($q) => $q->whereHas('typeTache', fn($t) => $t->where('nom', 'DOE OPTIQUE')),
        'taches.typeTache'
    ])->paginate(40);

    // Pour dropdown client
    $clients = Client::all();

    return view('doe.index', compact('projets', 'clients'));
}



  
public function listeAPD (Request $request){
    $user = auth()->user();
    $query = Projet::query()->with(['taches.typeTache', 'client']); 
    
    
    if ($user->hasRole('client')) {
       
        $query->where('clients_id', $user->clients_id)
              ->whereHas('taches', function($q) {
                  $q->whereHas('typeTache', function($q) {
                      $q->where('nom', 'APD GC/DOE GC');
                  });
              });
    } elseif (!$user->hasRole('admin')) {
        // Utilisateur normal voit uniquement ses tâches ROP
        $query->whereHas('taches', function($q) use ($user) {
            $q->where('users_id', $user->id)
              ->whereHas('typeTache', function($q) {
                  $q->where('nom', 'APD GC/DOE GC');
              });
        });
    } else {
        // Admin voit tout mais uniquement les projets avec tâches ROP
        $query->whereHas('taches', function($q) {
            $q->whereHas('typeTache', function($q) {
                $q->where('nom', 'APD GC/DOE GC');
            });
        });
    }

    // Filtrer par référence ou numéro de ticket dans un seul champ
    if ($request->filled('search')) {
        $query->where(function($q) use ($request) {
            $q->where('reference', 'like', '%'.$request->search.'%')
              ->orWhere('nom_site', 'like', '%'.$request->search.'%')
              ->orWhereHas('client', function($q) use ($request) {
                  $q->where('nom', 'like', '%'.$request->search.'%');
              });
        });
    }

    // Récupération des projets avec les tâches et types de tâches
    $projets = $query->with('taches', 'taches.typeTache')->paginate(10);
$clients = Client::all();
    return view('prodApd.index', compact('projets', 'clients'));
}


    public function destroy($id)
    {
        // Trouver la tâche par son ID
        $tache = Taches::findOrFail($id);
    
        // Récupérer le projet lié à la tâche
        $projet = Projet::where('reference', $tache->projet_reference)->firstOrFail();
    
        // Supprimer la tâche
        $tache->delete();
    
        // Rediriger vers la liste des tâches du projet avec un message de succès
        return redirect()->route('projets.taches.index', ['projet' => $projet->id])
            ->with('success', 'Tâche supprimée avec succès.');
    }
    

public function filter(Request $request)
{
    $query = Projet::query();

    // Filtrer par client
    if ($request->has('clients_id') && !empty($request->clients_id)) {
        $query->where('clients_id', $request->clients_id);
    }

    // Filtrer par date de commande
    if ($request->has('date_debut') && !empty($request->date_debut)) {
        $query->whereDate('date_commande', '>=', $request->date_debut);
    }

    if ($request->has('date_fin') && !empty($request->date_fin)) {
        $query->whereDate('date_commande', '<=', $request->date_fin);
    }

    // 🔎 Nouveau : Filtrer par date de livraison des tâches
    if (($request->has('livraison_debut') && !empty($request->livraison_debut)) ||
        ($request->has('livraison_fin') && !empty($request->livraison_fin))) {
        
        $query->whereHas('taches', function ($q) use ($request) {
            if ($request->has('livraison_debut') && !empty($request->livraison_debut)) {
                $q->whereDate('informations->date_livraison_rop', '>=', $request->livraison_debut);
            }
            if ($request->has('livraison_fin') && !empty($request->livraison_fin)) {
                $q->whereDate('informations->date_livraison_rop', '<=', $request->livraison_fin);
            }
        });
    }

if ($request->filled('statut')) {
    $query->whereHas('taches', function ($q) use ($request) {
        $q->where('informations->statut_rop', $request->statut);
    });
    
    // 🔑 Empêcher que le même projet s'affiche deux fois
    $query->distinct('projets.id');
}

    // Charger uniquement les tâches correspondant à l’intervalle demandé
    $query->with(['taches' => function ($q) use ($request) {
        if ($request->has('livraison_debut') && !empty($request->livraison_debut)) {
            $q->whereDate('informations->date_livraison_rop', '>=', $request->livraison_debut);
        }
        if ($request->has('livraison_fin') && !empty($request->livraison_fin)) {
            $q->whereDate('informations->date_livraison_rop', '<=', $request->livraison_fin);
        }
    }]);

    $projets = $query->paginate(40);
    $clients = Client::all();

    return view('projets.index', compact('projets', 'clients'));
}


public function search(Request $request)
{
    $query = Projet::query();

    if ($request->has('search') && !empty($request->search)) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('reference', 'LIKE', "%{$search}%")
              ->orWhere('nom_site', 'LIKE', "%{$search}%");
        });
    }

    $projets = $query->paginate(10);
    $clients = Client::all();
    return view('projets.index', compact('projets','clients'));
}

protected function applyFilters($query, $request)
{
    // Filtre client
    if ($request->filled('clients_id')) {
        $query->where('clients_id', $request->clients_id);
    }

    // Filtre statut + version ROP
    if ($request->filled('statut') || $request->filled('version_rop')) {
        $query->whereHas('taches', function ($q) use ($request) {

            $q->whereHas('typeTache', function ($t) {
                $t->where('nom', 'ROP');
            });

            if ($request->filled('statut')) {
                $q->where('informations->statut_rop', $request->statut);
            }

            if ($request->filled('version_rop')) {
                $q->where('informations->version_rop', $request->version_rop);
            }
        });
    }

    // Filtres date commande
    if ($request->filled('commande_debut')) {
        $query->whereDate('date_commande', '>=', $request->commande_debut);
    }
    if ($request->filled('commande_fin')) {
        $query->whereDate('date_commande', '<=', $request->commande_fin);
    }

    // Filtres date livraison
    if ($request->filled('livraison_debut') || $request->filled('livraison_fin')) {
        $query->whereHas('taches', function ($q) use ($request) {

            $q->whereHas('typeTache', function ($t) {
                $t->where('nom', 'ROP');
            });

            if ($request->filled('livraison_debut')) {
                $q->whereDate('informations->date_livraison_rop', '>=', $request->livraison_debut);
            }
            if ($request->filled('livraison_fin')) {
                $q->whereDate('informations->date_livraison_rop', '<=', $request->livraison_fin);
            }
        });
    }

    // Recherche
    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('reference', 'like', '%' . $request->search . '%')
              ->orWhere('nom_site', 'like', '%' . $request->search . '%');
        });
    }

    // Charger uniquement les tâches ROP filtrées
    $query->with(['taches' => function ($q) use ($request) {

        // Uniquement ROP
        $q->whereHas('typeTache', function ($t) {
            $t->where('nom', 'ROP');
        });

        // Statut
        if ($request->filled('statut')) {
            $q->where('informations->statut_rop', $request->statut);
        }

        // Version ROP filtrée
        if ($request->filled('version_rop')) {
            $q->where('informations->version_rop', $request->version_rop);
        }

        // Dates
        if ($request->filled('livraison_debut')) {
            $q->whereDate('informations->date_livraison_rop', '>=', $request->livraison_debut);
        }
        if ($request->filled('livraison_fin')) {
            $q->whereDate('informations->date_livraison_rop', '<=', $request->livraison_fin);
        }
    }]);
}


public function exportRop(Request $request)
{
    // Charger projets + tâches filtrées
    $query = Projet::query()
        ->with([
            'client',
            'taches' => function ($q) use ($request) {

                // Uniquement ROP
                $q->whereHas('typeTache', function ($t) {
                    $t->where('nom', 'ROP');
                });

                // Statut filtré
                if ($request->filled('statut')) {
                    $q->where('informations->statut_rop', $request->statut);
                }

                // Version filtrée (clé de la logique)
                if ($request->filled('version_rop')) {
                    $q->where('informations->version_rop', $request->version_rop);
                }

                // Dates livraison
                if ($request->filled('livraison_debut')) {
                    $q->whereDate('informations->date_livraison_rop', '>=', $request->livraison_debut);
                }

                if ($request->filled('livraison_fin')) {
                    $q->whereDate('informations->date_livraison_rop', '<=', $request->livraison_fin);
                }
            }
        ]);

    // Restrictions selon rôle
    $user = auth()->user();

    switch (true) {

        case $user->hasRole('client'):
            $query->where('clients_id', $user->clients_id);
            break;

        case !$user->hasAnyRole(['admin', 'client', 'Manager']):
            $query->whereHas('taches', function ($q) use ($user) {
                $q->where('users_id', $user->id);
            });
            break;
    }

    // Appliquer les filtres communs
    $this->applyFilters($query, $request);

    // IMPORTANT : exclure tout projet qui n’a pas une tâche ROP correspondant au filtre
    $query->whereHas('taches', function ($q) use ($request) {

        $q->whereHas('typeTache', function ($t) {
            $t->where('nom', 'ROP');
        });

        if ($request->filled('statut')) {
            $q->where('informations->statut_rop', $request->statut);
        }

        if ($request->filled('version_rop')) {
            $q->where('informations->version_rop', $request->version_rop);
        }
    });

    return Excel::download(new ProjetsRopExport($query), 'projets_rop_filtrés.xlsx');
}

 public function exportDoe(Request $request)
{
    $query = Projet::query()->with(['taches.typeTache', 'client']);

    // --- Même logique utilisateur que dans listeDOE() ---
    $user = auth()->user();

    if ($user->hasRole('client')) {
        $query->where('clients_id', $user->clients_id)
              ->whereHas('taches', fn($q) =>
                  $q->whereHas('typeTache', fn($t) => $t->where('nom', 'DOE OPTIQUE'))
              );
    } elseif (!$user->hasRole('admin')) {
        $query->whereHas('taches', fn($q) =>
            $q->where('users_id', $user->id)
              ->whereHas('typeTache', fn($t) => $t->where('nom', 'DOE OPTIQUE'))
        );
    } else {
        $query->whereHas('taches', fn($q) =>
            $q->whereHas('typeTache', fn($t) => $t->where('nom', 'DOE OPTIQUE'))
        );
    }

    // --- Filtres DOE identiques à la liste ---
    if ($request->filled('search')) {
        $query->where(function($q) use ($request) {
            $q->where('reference', 'like', '%'.$request->search.'%')
              ->orWhere('nom_site', 'like', '%'.$request->search.'%')
              ->orWhereHas('client', function($q) use ($request) {
                  $q->where('nom', 'like', '%'.$request->search.'%');
              });
        });
    }

    if ($request->filled('support')) {
        $query->whereHas('taches', function($q) use ($request) {
            $q->where('typeTache.nom', 'DOE OPTIQUE')
              ->where('informations->support', $request->support);
        });
    }

    if ($request->filled('statut_doe')) {
        $query->whereHas('taches', fn($q) =>
            $q->where('informations->statut_doe', $request->statut_doe)
        );
    }

   if ($request->filled('date_integration_debut')) {
    $query->whereHas('taches', function ($q) use ($request) {
        $q->whereHas('typeTache', fn($t) => $t->where('nom', 'DOE OPTIQUE'))
          ->whereRaw('date(json_unquote(json_extract(informations, "$.\"date_integration\""))) >= ?', [$request->date_integration_debut]);
    });
}

if ($request->filled('date_integration_fin')) {
    $query->whereHas('taches', function ($q) use ($request) {
        $q->whereHas('typeTache', fn($t) => $t->where('nom', 'DOE OPTIQUE'))
          ->whereRaw('date(json_unquote(json_extract(informations, "$.\"date_integration\""))) <= ?', [$request->date_integration_fin]);
    });
}


    return Excel::download(new DoeExport($request), 'DOE.xlsx');

}

public function ropParOperateur(Request $request)
{
    $query = Taches::select(
            'users.name as utilisateur',
            DB::raw("DATE(JSON_UNQUOTE(JSON_EXTRACT(taches.informations, '$.date_livraison_rop'))) as jour"),
            DB::raw('COUNT(*) as total')
        )
        ->join('projets', 'taches.projet_reference', '=', 'projets.reference')
        ->join('users', 'projets.users_id', '=', 'users.id')
        ->whereHas('typeTache', function ($q) {
            $q->where('nom', 'ROP');
        })
        ->whereNotNull('informations->date_livraison_rop');

    // Filtre utilisateur
    if ($request->filled('user_id')) {
        $query->where('users.id', $request->user_id);
    }

    // Filtre date
   $dateLivraison = DB::raw(
    "DATE(JSON_UNQUOTE(JSON_EXTRACT(taches.informations, '$.date_livraison_rop')))"
);

if ($request->filled('date_debut') && $request->filled('date_fin')) {

    $query->whereBetween($dateLivraison, [
        $request->date_debut,
        $request->date_fin
    ]);

} else {

    if ($request->filled('date_debut')) {
        $query->where($dateLivraison, '>=', $request->date_debut);
    }

    if ($request->filled('date_fin')) {
        $query->where($dateLivraison, '<=', $request->date_fin);
    }
}

    $stats = $query
    ->groupBy('users.id', 'users.name', 'jour')
    ->orderByDesc('jour')
    ->paginate(15)
    ->appends($request->all());

    $operateurs = User::role('operation')->orderBy('name')->get();

   // Données pour la courbe (non paginées)
$histogramData = (clone $query)
    ->groupBy('users.id', 'users.name')
    ->selectRaw("users.name as utilisateur, COUNT(*) as total")
    ->orderByDesc('total')
    ->get()
    ->map(fn($r) => ['utilisateur' => $r->utilisateur, 'total' => $r->total]);

return view('kpi.index', compact('stats', 'operateurs', 'histogramData'));
}

public function exportRopParOperateur(Request $request)
{
    $debut    = $request->date_debut ?? 'debut';
    $fin      = $request->date_fin   ?? 'fin';
    $filename = "rop_par_operateur_{$debut}_{$fin}.xlsx";

    return Excel::download(new RopParOperateurExport($request), $filename);
}

public function showRopGraph(Request $request)
{
    // 1. Construction de la requête de base (filtres sur les projets)
    $query = Projet::query();

    if ($request->filled('client_id')) {
        $query->where('clients_id', $request->client_id);
    }
    if ($request->filled('date_debut')) {
        $query->whereDate('date_commande', '>=', $request->date_debut);
    }
    if ($request->filled('date_fin')) {
        $query->whereDate('date_commande', '<=', $request->date_fin);
    }

    // 2. Restrictions de rôle
    $user = auth()->user();
    if ($user) {
        switch (true) {
            case $user->hasRole('client'):
                $query->where('clients_id', $user->clients_id);
                break;
            case !$user->hasAnyRole(['admin', 'client', 'Manager']):
                $query->whereHas('taches', fn($q) => $q->where('users_id', $user->id));
                break;
        }
    }

    $projetIds = $query->pluck('id');

    // 3. Agrégation des tâches ROP
    if ($projetIds->isEmpty()) {
        $labels            = [];
        $datasets          = [];
        $datasetsCapacite  = [];
        $datasetsNbreBpe   = [];
        $tableData         = [];
        $clients           = [];
        $perClientCharts   = [];
    } else {
        $ropQuery = Taches::query()
            ->join('projets', 'taches.projet_reference', '=', 'projets.reference')
            ->whereIn('projets.id', $projetIds)
            ->whereHas('typeTache', fn($q) => $q->where('nom', 'ROP'))
            ->whereNotNull('taches.informations->date_livraison_rop')
            ->when(!$request->filled('statut'), fn($q) => $q->where('taches.informations->statut_rop', 'Livré'));

        // Filtre client sur les tâches ROP
        if ($request->filled('client_id')) {
            $ropQuery->where('projets.clients_id', $request->client_id);
        }

        // Filtre plage de dates sur date_livraison_rop
        if ($request->filled('rop_date_debut')) {
            $ropQuery->whereRaw(
                "DATE(JSON_UNQUOTE(JSON_EXTRACT(taches.informations, '$.date_livraison_rop'))) >= ?",
                [$request->rop_date_debut]
            );
        }
        if ($request->filled('rop_date_fin')) {
            $ropQuery->whereRaw(
                "DATE(JSON_UNQUOTE(JSON_EXTRACT(taches.informations, '$.date_livraison_rop'))) <= ?",
                [$request->rop_date_fin]
            );
        }

        $results = $ropQuery
            ->select(
                DB::raw("DATE(JSON_UNQUOTE(JSON_EXTRACT(taches.informations, '$.date_livraison_rop'))) as date_livraison"),
                'projets.clients_id',
                DB::raw('COUNT(*) as total'),
                DB::raw("SUM(CAST(JSON_UNQUOTE(JSON_EXTRACT(taches.informations, '$.capacite')) AS DECIMAL(10,2))) as total_capacite"),
                DB::raw("SUM(CAST(JSON_UNQUOTE(JSON_EXTRACT(taches.informations, '$.nbre_bpe')) AS DECIMAL(10,2))) as total_nbre_bpe")
            )
            ->groupBy(
                DB::raw("DATE(JSON_UNQUOTE(JSON_EXTRACT(taches.informations, '$.date_livraison_rop')))"),
                'projets.clients_id'
            )
            ->orderBy('date_livraison')
            ->get();

        if ($results->isEmpty()) {
            $labels            = [];
            $datasets          = [];
            $datasetsCapacite  = [];
            $datasetsNbreBpe   = [];
            $tableData         = [];
            $clients           = [];
            $perClientCharts   = [];
        } else {
            $clientIds = $results->pluck('clients_id')->unique();
            $clients   = Client::whereIn('id', $clientIds)->pluck('nom', 'id');
            $dates     = $results->pluck('date_livraison')->unique()->sort()->values();
            $labels    = $dates->toArray();
            $colors    = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'];

            // ===================================================
            // OPTIMISATION CLE : indexation pour accès O(1)
            // au lieu de ->first() avec closure en boucle imbriquee
            // (qui rescannait toute la collection a chaque appel,
            // 5 fois, pour chaque combinaison date x client)
            // ===================================================
            $resultsIndexed = [];
            foreach ($results as $item) {
                $key = $item->date_livraison . '|' . $item->clients_id;
                $resultsIndexed[$key] = $item;
            }

            // Tableau pivot
            $tableData = [];
            foreach ($dates as $date) {
                $row = ['date' => $date];
                foreach ($clients as $clientId => $clientNom) {
                    $found = $resultsIndexed[$date . '|' . $clientId] ?? null;
                    $row[$clientId] = $found ? (int) $found->total : 0;
                    $row['capacite_' . $clientId] = $found ? (float) $found->total_capacite : 0;
                    $row['nbre_bpe_' . $clientId]  = $found ? (float) $found->total_nbre_bpe  : 0;
                }
                $row['total']          = array_sum(array_map(fn($id) => $row[$id], $clients->keys()->toArray()));
                $row['total_capacite'] = array_sum(array_map(fn($id) => $row['capacite_' . $id], $clients->keys()->toArray()));
                $row['total_nbre_bpe'] = array_sum(array_map(fn($id) => $row['nbre_bpe_' . $id], $clients->keys()->toArray()));
                $tableData[] = $row;
            }

            // Couleurs fixes par type de mesure (cohérent avec la légende statique de la vue)
            $colorRop = '#06b6d4'; // cyan
            $colorCap = '#fb923c'; // orange
            $colorBpe = '#a855f7'; // violet

            // Datasets ROP — un dataset "barre" par client (couleur fixe cyan)
            $datasets = [];
            foreach ($clients as $clientId => $clientNom) {
                $data = [];
                foreach ($dates as $date) {
                    $found  = $resultsIndexed[$date . '|' . $clientId] ?? null;
                    $data[] = $found ? (int) $found->total : 0;
                }
                $datasets[] = [
                    'label'           => $clientNom,
                    'data'            => $data,
                    'type'            => 'bar',
                    'backgroundColor' => $colorRop . 'aa',
                    'borderColor'     => $colorRop,
                    'borderWidth'     => 1,
                ];
            }

            // Datasets Capacité — un dataset "barre" par client (couleur fixe orange)
            $datasetsCapacite = [];
            foreach ($clients as $clientId => $clientNom) {
                $data = [];
                foreach ($dates as $date) {
                    $found  = $resultsIndexed[$date . '|' . $clientId] ?? null;
                    $data[] = $found ? (float) $found->total_capacite : 0;
                }
                $datasetsCapacite[] = [
                    'label'           => $clientNom,
                    'data'            => $data,
                    'type'            => 'bar',
                    'backgroundColor' => $colorCap . 'aa',
                    'borderColor'     => $colorCap,
                    'borderWidth'     => 1,
                ];
            }

            // Datasets Nbre BPE — un dataset "barre" par client (couleur fixe violet)
            $datasetsNbreBpe = [];
            foreach ($clients as $clientId => $clientNom) {
                $data = [];
                foreach ($dates as $date) {
                    $found  = $resultsIndexed[$date . '|' . $clientId] ?? null;
                    $data[] = $found ? (float) $found->total_nbre_bpe : 0;
                }
                $datasetsNbreBpe[] = [
                    'label'           => $clientNom,
                    'data'            => $data,
                    'type'            => 'bar',
                    'backgroundColor' => $colorBpe . 'aa',
                    'borderColor'     => $colorBpe,
                    'borderWidth'     => 1,
                ];
            }

            // Données "par client" prêtes à boucler côté vue : un canvas ROP + Capacité + BPE par client
            $perClientCharts = [];
            foreach ($clients as $clientId => $clientNom) {
                $dataRop = [];
                $dataCap = [];
                $dataBpe = [];
                foreach ($dates as $date) {
                    $found     = $resultsIndexed[$date . '|' . $clientId] ?? null;
                    $dataRop[] = $found ? (int)   $found->total          : 0;
                    $dataCap[] = $found ? (float) $found->total_capacite : 0;
                    $dataBpe[] = $found ? (float) $found->total_nbre_bpe : 0;
                }
                $perClientCharts[] = [
                    'client_id'   => $clientId,
                    'client_nom'  => $clientNom,
                    'rop'         => $dataRop,
                    'capacite'    => $dataCap,
                    'bpe'         => $dataBpe,
                ];
            }

        }
    }

    $allClients = Client::all();

    return view('rop-graph.index', compact(
        'labels',
        'datasets',
        'datasetsCapacite',
        'datasetsNbreBpe',
        'tableData',
        'clients',
        'allClients',
        'perClientCharts'
    ));
}


public function exportRopGraph(Request $request)
{
    // --- Logique identique à showRopGraph pour garantir la cohérence des filtres ---
    $query = Projet::query();

    if ($request->filled('client_id')) {
        $query->where('clients_id', $request->client_id);
    }
    if ($request->filled('date_debut')) {
        $query->whereDate('date_commande', '>=', $request->date_debut);
    }
    if ($request->filled('date_fin')) {
        $query->whereDate('date_commande', '<=', $request->date_fin);
    }

    $user = auth()->user();
    if ($user) {
        switch (true) {
            case $user->hasRole('client'):
                $query->where('clients_id', $user->clients_id);
                break;
            case !$user->hasAnyRole(['admin', 'client', 'Manager']):
                $query->whereHas('taches', fn($q) => $q->where('users_id', $user->id));
                break;
        }
    }

    $projetIds = $query->pluck('id');

    $tableData = [];
    $clients   = collect();

    if ($projetIds->isNotEmpty()) {
        $ropQuery = Taches::query()
            ->join('projets', 'taches.projet_reference', '=', 'projets.reference')
            ->whereIn('projets.id', $projetIds)
            ->whereHas('typeTache', fn($q) => $q->where('nom', 'ROP'))
            ->whereNotNull('taches.informations->date_livraison_rop')
            ->when(!$request->filled('statut'), fn($q) => $q->where('taches.informations->statut_rop', 'Livré'));

        if ($request->filled('client_id')) {
            $ropQuery->where('projets.clients_id', $request->client_id);
        }
        if ($request->filled('rop_date_debut')) {
            $ropQuery->whereRaw(
                "DATE(JSON_UNQUOTE(JSON_EXTRACT(taches.informations, '$.date_livraison_rop'))) >= ?",
                [$request->rop_date_debut]
            );
        }
        if ($request->filled('rop_date_fin')) {
            $ropQuery->whereRaw(
                "DATE(JSON_UNQUOTE(JSON_EXTRACT(taches.informations, '$.date_livraison_rop'))) <= ?",
                [$request->rop_date_fin]
            );
        }

        $results = $ropQuery
            ->select(
                DB::raw("DATE(JSON_UNQUOTE(JSON_EXTRACT(taches.informations, '$.date_livraison_rop'))) as date_livraison"),
                'projets.clients_id',
                DB::raw('COUNT(*) as total'),
                DB::raw("SUM(CAST(JSON_UNQUOTE(JSON_EXTRACT(taches.informations, '$.capacite')) AS DECIMAL(10,2))) as total_capacite"),
                DB::raw("SUM(CAST(JSON_UNQUOTE(JSON_EXTRACT(taches.informations, '$.nbre_bpe')) AS DECIMAL(10,2))) as total_nbre_bpe")
            )
            ->groupBy(
                DB::raw("DATE(JSON_UNQUOTE(JSON_EXTRACT(taches.informations, '$.date_livraison_rop')))"),
                'projets.clients_id'
            )
            ->orderBy('date_livraison')
            ->get();

        if ($results->isNotEmpty()) {
            $clientIds = $results->pluck('clients_id')->unique();
            $clients   = Client::whereIn('id', $clientIds)->pluck('nom', 'id');
            $dates     = $results->pluck('date_livraison')->unique()->sort()->values();

            $resultsIndexed = [];
            foreach ($results as $item) {
                $key = $item->date_livraison . '|' . $item->clients_id;
                $resultsIndexed[$key] = $item;
            }

            foreach ($dates as $date) {
                $row = ['date' => $date];
                foreach ($clients as $clientId => $clientNom) {
                    $found = $resultsIndexed[$date . '|' . $clientId] ?? null;
                    $row[$clientId] = $found ? (int) $found->total : 0;
                    $row['capacite_' . $clientId] = $found ? (float) $found->total_capacite : 0;
                    $row['nbre_bpe_' . $clientId]  = $found ? (float) $found->total_nbre_bpe  : 0;
                }
                $row['total']          = array_sum(array_map(fn($id) => $row[$id], $clients->keys()->toArray()));
                $row['total_capacite'] = array_sum(array_map(fn($id) => $row['capacite_' . $id], $clients->keys()->toArray()));
                $row['total_nbre_bpe'] = array_sum(array_map(fn($id) => $row['nbre_bpe_' . $id], $clients->keys()->toArray()));
                $tableData[] = $row;
            }
        }
    }

    $filename = 'rapport_rop_' . now()->format('Y-m-d_H-i') . '.xlsx';

    return Excel::download(new RopGraphExport($tableData, $clients), $filename);
}
}
