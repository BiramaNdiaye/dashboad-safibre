<?php

namespace App\Http\Controllers;
use App\Models\Frontal;
use App\Models\Etude;
use App\Models\Projet;
use Illuminate\Http\Request;

class FrontalController extends Controller
{
    public function create()
    {
        $projets = Projet::all(); 
        return view('frontals.create', compact('projets'));
    }

    // Stocker le frontal
 public function store(Request $request)
{
    $request->validate([

        'type_projet' => 'required|string',
        'statut_fci' => 'required|string|in:simple,complexe,annulation,Accompagnement',
        'date_declaration' => 'required|date',
        'numero_fci' => 'required|unique:frontals,numero_fci',
        'reference' => 'required|exists:projets,reference',
        'codes_ensee.*' => 'required|string',
        'etudes_ids.*.*' => 'required|exists:etudes,id',

    ], [

        // type_projet
        'type_projet.required' => 'Veuillez sélectionner un type de projet.',
        'type_projet.string' => 'Le type de projet doit être un texte valide.',

        // statut_fci
        'statut_fci.required' => 'Veuillez choisir un statut FCI.',
        'statut_fci.in' => 'Le statut FCI sélectionné est invalide.',

        // date_declaration
        'date_declaration.required' => 'Veuillez renseigner la date de déclaration.',
        'date_declaration.date' => 'La date de déclaration doit être une date valide.',

        // numero_fci
        'numero_fci.required' => 'Le numéro FCI est obligatoire.',
        'numero_fci.unique' => 'Ce numéro FCI existe déjà.',

        // reference
        'reference.required' => 'Veuillez sélectionner une référence projet.',
        'reference.exists' => 'La référence sélectionnée est invalide ou inexistante.',

        // codes_ensee.* (liste dynamique)
        'codes_ensee.*.required' => 'Veuillez renseigner le code Ensee.',
        'codes_ensee.*.string' => 'Le code Ensee doit être un texte valide.',

        // etudes_ids.*.* (liste dynamique)
        'etudes_ids.*.*.required' => 'Veuillez sélectionner un numéro d’étude.',
        'etudes_ids.*.*.exists' => 'Le numéro d’étude sélectionné est invalide.',
    ]);

    // Création
    $frontal = Frontal::create($request->only(
        'type_projet',
        'statut_fci',
        'date_declaration',
        'numero_fci',
        'numero_fci_annulation',
        'reference'
    ));

    // Gestion des études
    if ($request->statut_fci === 'complexe') {
        foreach ($request->etudes_ids as $etudesIds) {
            $frontal->etudes()->attach($etudesIds);
        }
    } else {
        if (!empty($request->etudes_ids[0][0])) {
            $frontal->etudes()->attach($request->etudes_ids[0][0]);
        }
    }

    return redirect()->route('frontals.create')
        ->with('success', 'FCI créé avec succès !');
}




   public function index(Request $request)
{
    $query = Frontal::with('etudes', 'projet');

    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function($q) use ($search) {
            // Numéro FCI
            $q->where('numero_fci', 'like', "%{$search}%")
              // Numéro d'étude via relation etudes
              ->orWhereHas('etudes', function($q2) use ($search) {
                  $q2->where('numero_etude', 'like', "%{$search}%")
                     ->orWhere('code_ensee', 'like', "%{$search}%");
              });
        });
    }
if ($request->filled('date_from')) {
        $query->whereDate('date_declaration', '>=', $request->date_from);
    }

    if ($request->filled('date_to')) {
        $query->whereDate('date_declaration', '<=', $request->date_to);
    }
     $query->orderBy('date_declaration', 'desc');
     $frontals = $query->paginate(20)->withQueryString();
    return view('frontals.index', compact('frontals'));
}

    public function edit(Frontal $frontal)
{
    $projets = Projet::all();


    $etudes = $frontal->etudes; 

    return view('frontals.edit', compact('frontal', 'projets', 'etudes'));
}

  
    public function update(Request $request, Frontal $frontal)
{
    $request->validate([
        'type_projet' => 'required|string',
        'statut_fci' => 'required|string|in:simple,complexe,annulation,Accompagnement',
        'date_declaration' => 'required|date',
        'numero_fci' => 'required|unique:frontals,numero_fci,' . $frontal->id,
        'reference' => 'required|exists:projets,reference',
        'codes_ensee.*' => 'required|string',
        'etudes_ids.*.*' => 'required|exists:etudes,id',
    ], [
        'etudes_ids.*.*.required' => 'Veuillez sélectionner un numéro d’étude.',
        'codes_ensee.*.required' => 'Le code Ensee est requis.',
    ]);

    // Mettre à jour les champs principaux
    $frontal->update($request->only(
        'type_projet',
        'statut_fci',
        'date_declaration',
        'numero_fci',
        'numero_fci_annulation',
        'reference'
    ));

    
    $etudesIdsToAttach = [];

    if ($request->statut_fci === 'complexe') {
        foreach ($request->etudes_ids as $etudesIds) {
            foreach ($etudesIds as $id) {
                $etudesIdsToAttach[] = $id;
            }
        }
    } else {
        // simple ou autre → attacher la première étude sélectionnée
        if (!empty($request->etudes_ids[0][0])) {
            $etudesIdsToAttach[] = $request->etudes_ids[0][0];
        }
    }

    // Synchroniser la relation many-to-many
    $frontal->etudes()->sync($etudesIdsToAttach);

    return redirect()->route('frontals.index')->with('success', 'FCI mis à jour avec succès !');
}

}
