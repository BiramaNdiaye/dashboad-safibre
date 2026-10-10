<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use App\Models\Commande;
use App\Models\CommandeElement;
use Illuminate\Http\Request;
use App\Exports\CommandesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;


class CommandeController extends Controller
{
 public function index(Request $request)
{
    $query = Commande::with(['client', 'user'])->withCount('commandeElements');

    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('reference', 'like', '%' . $request->search . '%')
              ->orWhere('nom_site', 'like', '%' . $request->search . '%');
        });
    }

    if ($request->filled('statut')) {
        $query->where('statut', $request->statut);
    }

    if ($request->filled('client_id')) {
        $query->where('client_id', $request->client_id);
    }

    if ($request->filled('date_livraison_debut')) {
        $query->whereDate('date_livraison', '>=', $request->date_livraison_debut);
    }

    if ($request->filled('date_livraison_fin')) {
        $query->whereDate('date_livraison', '<=', $request->date_livraison_fin);
    }

    $commandes = $query->latest()->paginate(20)->withQueryString();

    // Récupération des clients pour le select
    $clients = Client::orderBy('nom')->get();

    return view('commandes.index', compact('commandes', 'clients'));
}

   public function create()
{
    $clients = Client::orderBy('nom')->get();
    $users = User::orderBy('name')->get();

    return view('commandes.create', compact(
        'clients',
        'users'
    ));
}

    public function store(Request $request)
    {
        $request->validate([
            
            'nom_site' => 'required',
            'client_id' => 'required|exists:clients,id',
            'user_id' => 'required|exists:users,id',
             'statut' => 'required|in:en_cours,livré,traité',
            
        ]);
  // Génération d'une référence unique
   do {
    $reference = 'CSMA-' . date('Y') . '-' . date('m') . '-' . date('d') . '-' . strtoupper(Str::random(4));
} while (Commande::where('reference', $reference)->exists());

        $commande = Commande::create([
            'reference' => $reference,
            'nom_site' => $request->nom_site,
            'client_id' => $request->client_id,
            'user_id' => $request->user_id,
            'statut' => $request->statut,
            'description' => $request->description,
            'commentaire' => $request->commentaire,
            'date_reception' => $request->date_reception,
            'date_livraison' => $request->date_livraison,
        ]);

        foreach ($request->elements ?? [] as $elementData) {

            $element = $commande->commandeElements()->create([
                'type' => $elementData['type'],
                'nom' => $elementData['nom'],
                'action' => $elementData['action'],
                'ancien_nom' => $elementData['ancien_nom'] ?? null,
                'origine' => $elementData['origine'] ?? null,
                'destination' => $elementData['destination'] ?? null,
                'capacite_fo' => $elementData['capacite_fo'] ?? null,
                'commentaire' => $elementData['commentaire'] ?? null,
            ]);

            if (
                $element->type === 'cable' &&
                !empty($elementData['liaisons'])
            ) {

                foreach ($elementData['liaisons'] as $liaisonData) {

                    $element->liaisons()->create([
                        'origine' => $liaisonData['origine'],
                        'destination' => $liaisonData['destination'],
                        'distance' => $liaisonData['distance'] ?? null,
                        'capacite_fo' => $liaisonData['capacite_fo'] ?? null,
                        'commentaire' => $liaisonData['commentaire'] ?? null,
                    ]);
                }
            }
        }

        return redirect()
            ->route('commandes.show', $commande)
            ->with('success', 'Commande créée avec succès.');
    }

    public function show(Commande $commande)
{
    $commande->load([
        'client',
        'user',
        'commandeElements.liaisons'
    ]);

    return view('commandes.show', compact('commande'));
}

    public function edit(Commande $commande)
{
    $clients = Client::orderBy('nom')->get();
    $users = User::orderBy('name')->get();

    $commande->load('commandeElements');

    return view('commandes.edit', compact(
        'commande',
        'clients',
        'users'
    ));
}

   public function update(Request $request, Commande $commande)
{
    $commande->update([
        'reference'       => $request->reference,
        'nom_site'        => $request->nom_site,
        'client_id'       => $request->client_id,
        'user_id'         => $request->user_id,
        'date_reception'  => $request->date_reception,
        'date_livraison'  => $request->date_livraison,
        'description'     => $request->description,
        'statut'     => $request->statut,
    ]);

    // Supprime les anciens éléments
    $commande->commandeElements()->delete();

    // Recréation
    foreach ($request->elements ?? [] as $elementData) {

        $commande->commandeElements()->create([
            'type'          => $elementData['type'],
            'nom'           => $elementData['nom'],
            'action'        => $elementData['action'],
            'origine'       => $elementData['origine'] ?? null,
            'destination'   => $elementData['destination'] ?? null,
            'statut'   => $elementData['statut'] ?? null,
            'capacite_fo'   => $elementData['capacite_fo'] ?? null,
            'commentaire'   => $elementData['commentaire'] ?? null,
        ]);
    }

    return redirect()
        ->route('commandes.show', $commande)
        ->with('success', 'Commande mise à jour.');
}
    public function destroy(Commande $commande)
    {
        $commande->delete();

        return redirect()
            ->route('commandes.index')
            ->with('success', 'Commande supprimée.');
    }
 public function exportExcel(Request $request)
{
    // Récupérer tous les paramètres de filtrage
    $filters = $request->only([
        'search',
        'statut',
        'client_id',
        'date_livraison_debut',
        'date_livraison_fin'
    ]);

    return Excel::download(
        new CommandesExport($filters),
        'commandes.xlsx'
    );
}
}