<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EtudeFaisa;
use Illuminate\Support\Facades\DB;
class EtudeFaisabiController extends Controller
{
   public function index(Request $request)
{
    // Initialiser la requête
    $query = EtudeFaisa::query();
    
    // Recherche globale
    if ($request->has('search') && !empty($request->search)) {
        $searchTerm = '%' . $request->search . '%';
        
        $query->where(function($q) use ($searchTerm) {
            $q->where('code_ensei', 'LIKE', $searchTerm)
              ->orWhere('commune', 'LIKE', $searchTerm)
              ->orWhere('numero_etude', 'LIKE', $searchTerm)
              ->orWhere('code_postal', 'LIKE', $searchTerm);
        });
    }
    
    // Trier par date de création (plus récent d'abord)
    $query->orderBy('created_at', 'desc');
    
    // Pagination
    $etudesfais = $query->paginate(20);
    
    // Passer le terme de recherche à la vue
    return view('nexloop.etudes.index', compact('etudesfais'))
        ->with('search', $request->search ?? '');
}

     public function create()
    {
        return view('nexloop.etudes.create');
    }

    public function store(Request $request)
{
    $messages = [
        'commune.required' => 'Le champ commune est obligatoire.',
        'code_postal.required' => 'Le champ code postal est obligatoire.',
        'code_ensei' => 'Le champ code ensei est obligatoire.',
        'numero_etude.required' => 'Le numero etude est obligatoire.',
        
    ];

    $validatedData = $request->validate([
        'commune' => 'required|string|max:255',
        'code_postal' => 'required|integer|min:0',
        'code_ensei' => 'required|integer|min:0',
        'numero_etude' => 'required|string|max:255',
        
    ], $messages);

    // Ajouter l'utilisateur connecté
    $validatedData['users_id'] = auth()->id();

    EtudeFaisa::create($validatedData);

    return redirect()->route('nexloop.etudes.index')
                     ->with('success', 'étude de faisabilité créé avec succès.');
}


public function search(Request $request)
{
    $request->validate([
        'code_ensei' => 'required|string',
    ]);

    // Retourne les études correspondant au code_ensei
    $etudes = EtudeFaisa::where('code_ensei', 'LIKE', $request->code_ensei . '%')
                    ->get(['id', 'numero_etude']);

    return response()->json($etudes);
}

public function edit($id)
{
    // Récupérer l'étude à éditer
    $etude = EtudeFaisa::findOrFail($id);
    
    // Vérifier que l'utilisateur est bien le propriétaire (si nécessaire)
   //  if($etude->users_id !== auth()->id()) {
        //abort(403, 'Accès non autorisé');
   // }
    
    return view('nexloop.etudes.edit', compact('etude'));
}

public function update(Request $request, $id)
{
    // Récupérer l'étude à mettre à jour
    $etude = EtudeFaisa::findOrFail($id);
    
    // Vérifier que l'utilisateur est bien le propriétaire (si nécessaire)
    // if($etude->users_id !== auth()->id()) {
    // abort(403, 'Accès non autorisé');
   //  }
    
    $messages = [
        'commune.required' => 'Le champ commune est obligatoire.',
        'code_postal.required' => 'Le champ code postal est obligatoire.',
        'code_ensei.required' => 'Le champ code ensei est obligatoire.',
        'code_ensei.integer' => 'Le code ensei doit être un nombre entier.',
        'code_ensei.min' => 'Le code ensei doit être supérieur ou égal à 0.',
        'numero_etude.required' => 'Le numéro d\'étude est obligatoire.',
        'code_postal.integer' => 'Le code postal doit être un nombre entier.',
        'code_postal.min' => 'Le code postal doit être supérieur ou égal à 0.',
    ];

    $validatedData = $request->validate([
        'commune' => 'required|string|max:255',
        'code_postal' => 'required|integer|min:0',
        'code_ensei' => 'required|integer|min:0',
        'numero_etude' => 'required|string|max:255',
    ], $messages);

    // Mettre à jour l'étude
    $etude->update($validatedData);

    return redirect()->route('nexloop.etudes.index')
                     ->with('success', 'Étude de faisabilité mise à jour avec succès.');
}

public function destroy($id)
{
    $etude = EtudeFaisa::findOrFail($id);
    
    // Vérifier que l'utilisateur est bien le propriétaire (si nécessaire)
    // if($etude->users_id !== auth()->id()) {
    //     abort(403, 'Accès non autorisé');
    // }
    
    // Vérifier si l'étude est utilisée dans des FCIs
    $isUsed = DB::table('code_ensei_etude')
        ->where('etude_faisa_id', $id)
        ->exists();
    
    if ($isUsed) {
        return redirect()->route('nexloop.etudes.index')
            ->with('error', 'Cette étude ne peut pas être supprimée car elle est associée à un ou plusieurs FCIs.');
    }
    
    $etude->delete();
    
    return redirect()->route('nexloop.etudes.index')
        ->with('success', 'Étude de faisabilité supprimée avec succès.');
}
}
