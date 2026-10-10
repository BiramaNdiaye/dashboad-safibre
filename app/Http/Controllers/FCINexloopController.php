<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FCINexloop;
use Illuminate\Support\Facades\DB;
class FCINexloopController extends Controller
{
public function index(Request $request)
{
    // Construction de la requête de base
    $query = DB::table('f_c_i_nexloops as fci')
        ->select(
            'fci.id',
            'fci.site',
            'fci.type',
            'fci.numero_fci',
            'client',
            DB::raw("(
                SELECT GROUP_CONCAT(
                    CONCAT(ef.code_ensei, ' - ', ef.numero_etude) 
                    ORDER BY ef.code_ensei, ef.numero_etude 
                    SEPARATOR '; '
                )
                FROM code_ensei_etude ce2
                INNER JOIN etude_faisas ef ON ce2.etude_faisa_id = ef.id
                WHERE ce2.f_c_i_nexloop_id = fci.id
            ) as etudes_list"),
            DB::raw("(
                SELECT GROUP_CONCAT(
                    CONCAT(ef.commune, ' (', ef.code_postal, ')') 
                    ORDER BY ef.commune 
                    SEPARATOR '; '
                )
                FROM code_ensei_etude ce2
                INNER JOIN etude_faisas ef ON ce2.etude_faisa_id = ef.id
                WHERE ce2.f_c_i_nexloop_id = fci.id
            ) as communes_list")
        );
    
    // Recherche par site
    if ($request->has('search_site') && !empty($request->search_site)) {
        $searchSite = '%' . $request->search_site . '%';
        $query->where('fci.site', 'LIKE', $searchSite);
    }
    
    // Recherche par numéro FCI
    if ($request->has('search_numero_fci') && !empty($request->search_numero_fci)) {
        $searchNumeroFci = '%' . $request->search_numero_fci . '%';
        $query->where('fci.numero_fci', 'LIKE', $searchNumeroFci);
    }
    
    // Recherche par type
    if ($request->has('search_type') && !empty($request->search_type)) {
        $query->where('fci.type', $request->search_type);
    }
    
    // Exécuter la pagination
    $fcinexloops = $query->orderBy('fci.created_at', 'desc')->paginate(20);
    
    // Passer les termes de recherche à la vue pour les garder dans le formulaire
    return view('nexloop.fci.index', compact('fcinexloops'))
        ->with('search_site', $request->search_site ?? '')
        ->with('search_numero_fci', $request->search_numero_fci ?? '')
        ->with('search_type', $request->search_type ?? '');
}
    
    public function show($id)
{
    // Récupérer le FCI
    $fci = FCINexloop::findOrFail($id);
    
    // Récupérer les études associées via une requête explicite
    $etudes = DB::table('code_ensei_etude as ce')
        ->join('etude_faisas as ef', 'ce.etude_faisa_id', '=', 'ef.id')
        ->where('ce.f_c_i_nexloop_id', $id)
        ->select(
            'ef.id',
            'ef.code_ensei',
            'ef.numero_etude',
            'ef.commune',
            'ef.code_postal'
        )
        ->get();
    
    return view('nexloop.fci.show', compact('fci', 'etudes'));
}

    public function create(){
      
        return view('nexloop.fci.create');
    }

public function store(Request $request)
{
    $request->validate([
        'site' => 'required|string',
        'type' => 'required|string|in:Simple,Complexe',
        'numero_fci' => 'required|unique:f_c_i_nexloops,numero_fci',
        'client' => 'required|string',
        'codes_ensei.*' => 'required|string',
        'etudes_ids.*.*' => 'required|exists:etude_faisas,id',
    ]);

    DB::beginTransaction();
    
    try {
        // Pour tous les types, créer un seul FCI
        // Pour Complexe, on peut stocker tous les codes_ensei dans un champ JSON ou texte
        $frontal = FCINexloop::create([
            'site' => $request->site,
            'type' => $request->type,
            'code_ensei' => $request->codes_ensei[0] ?? null, // Premier code
            'numero_fci' => $request->numero_fci,
        ]);
        
        // Attacher les études selon le type
        if ($request->type === 'Simple') {
            // Pour Simple: attacher la première étude
            if (isset($request->etudes_ids[0][0])) {
                $frontal->etudes()->attach($request->etudes_ids[0][0]);
            }
        } else {
            // Pour Complexe: attacher toutes les études
            $etudesIds = [];
            foreach ($request->etudes_ids as $etudesArray) {
                if (isset($etudesArray[0])) {
                    $etudesIds[] = $etudesArray[0];
                }
            }
            
            if (!empty($etudesIds)) {
                $frontal->etudes()->attach($etudesIds);
            }
        }
        
        DB::commit();
        
        return redirect()->route('nexloop.fci.index')
            ->with('success', 'FCI créé avec succès !');
            
    } catch (\Exception $e) {
        DB::rollback();
        
        return redirect()->back()
            ->withInput()
            ->withErrors(['error' => 'Erreur lors de la création du FCI: ' . $e->getMessage()]);
    }
}

public function edit($id)
{
    // Récupérer le FCI avec ses études
    $fci = FCINexloop::with(['etudes' => function($query) {
        $query->select('etude_faisas.id', 'code_ensei', 'numero_etude');
    }])->findOrFail($id);
    
    // Récupérer tous les codes_ensei disponibles (pour l'autocomplete)
    $codesEnsei = DB::table('etude_faisas')
        ->select('code_ensei')
        ->distinct()
        ->orderBy('code_ensei')
        ->get();
    
    return view('nexloop.fci.edit', compact('fci', 'codesEnsei'));
}

public function update(Request $request, $id)
{
    $fci = FCINexloop::findOrFail($id);
    
    $request->validate([
        'site' => 'required|string',
        'type' => 'required|string|in:Simple,Complexe',
        'numero_fci' => 'required|unique:f_c_i_nexloops,numero_fci,' . $id,
        'client' => 'required|unique:f_c_i_nexloops,client',
        'codes_ensei.*' => 'required|string',
        'etudes_ids.*.*' => 'required|exists:etude_faisas,id',
    ], [
        'numero_fci.required' => 'Le numéro FCI est obligatoire.',
        'numero_fci.unique' => 'Ce numéro FCI existe déjà.',
        'codes_ensei.*.required' => 'Veuillez renseigner le code Ensei.',
        'codes_ensei.*.string' => 'Le code Ensei doit être un texte valide.',
        'etudes_ids.*.*.required' => 'Veuillez sélectionner un numéro d\'étude.',
        'etudes_ids.*.*.exists' => 'Le numéro d\'étude sélectionné est invalide.',
    ]);
    
    DB::beginTransaction();
    
    try {
        // Mettre à jour les informations de base du FCI
        $fci->update([
            'site' => $request->site,
            'type' => $request->type,
            'numero_fci' => $request->numero_fci,
            // Pour le code_ensei, on prend le premier de la liste
            'code_ensei' => $request->codes_ensei[0] ?? null,
        ]);
        
        // Synchroniser les études (supprime les anciennes et ajoute les nouvelles)
        $etudesIds = [];
        
        // Pour chaque paire code_ensei - étude
        foreach ($request->etudes_ids as $index => $etudesArray) {
            if (isset($etudesArray[0])) {
                $etudesIds[] = $etudesArray[0];
            }
        }
        
        $fci->etudes()->sync($etudesIds);
        
        DB::commit();
        
        return redirect()->route('nexloop.fci.index')
            ->with('success', 'FCI mis à jour avec succès !');
            
    } catch (\Exception $e) {
        DB::rollback();
        
        return redirect()->back()
            ->withInput()
            ->withErrors(['error' => 'Erreur lors de la mise à jour du FCI: ' . $e->getMessage()]);
    }
}

public function destroy($id)
{
    $fci = FCINexloop::findOrFail($id);
    
    DB::beginTransaction();
    
    try {
        // Détacher toutes les études d'abord
        $fci->etudes()->detach();
        
        // Supprimer le FCI
        $fci->delete();
        
        DB::commit();
        
        return redirect()->route('nexloop.fci.index')
            ->with('success', 'FCI supprimé avec succès !');
            
    } catch (\Exception $e) {
        DB::rollback();
        
        return redirect()->route('nexloop.fci.index')
            ->with('error', 'Erreur lors de la suppression du FCI: ' . $e->getMessage());
    }
}
}
