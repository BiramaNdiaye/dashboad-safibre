<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Etude;
use App\Models\Client;
class EtudeController extends Controller
{
 public function index(Request $request)
{
    $query = Etude::with('client');

    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('code_ensee', 'LIKE', "%$search%")
              ->orWhere('numero_etude', 'LIKE', "%$search%")
              ->orWhere('commune', 'LIKE', "%$search%");
        });
    }

    $etudes = $query->paginate(20)->withQueryString();

    return view('etudes.index', compact('etudes'));
}

public function edit(Etude $etude)
{
    $clients = Client::all(); // pour pouvoir changer le client si besoin
    return view('etudes.edit', compact('etude', 'clients'));
}

public function update(Request $request, Etude $etude)
{
    $request->validate([
        'code_ensee' => 'required|string',
        'commune' => 'required|string',
        'clients_id' => 'required|exists:clients,id',
        'numero_etude' => 'required|string',
    ]);

    $etude->update($request->all());

    return redirect()->route('etudes.index')->with('success', 'Étude mise à jour avec succès !');
}

    public function create()
    {
        // Récupérer tous les clients pour le select
        $clients = Client::all();
        return view('etudes.create', compact('clients'));
    }

    public function store(Request $request)
{
    $messages = [
        'code_ensee.required' => 'Le code Ensee est obligatoire.',
        'commune.required' => 'La commune est obligatoire.',
        'clients_id.required' => 'Le client doit être sélectionné.',
        'clients_id.exists' => 'Le client sélectionné est invalide.',
        'numero_etude.required' => "Le numéro d'étude est obligatoire.",
        'numero_etude.unique' => "Ce numéro d'étude existe déjà pour un autre enregistrement.",
    ];

    $request->validate([
        'code_ensee' => 'required|string',
        'commune' => 'required|string',
        'clients_id' => 'required|exists:clients,id',
        'numero_etude' => 'required|unique:etudes,numero_etude',
    ], $messages);

    Etude::create($request->all());

    return redirect()->route('etudes.index')->with('success', 'Étude créée avec succès !');
}
public function search(Request $request)
{
    $request->validate([
        'code_ensee' => 'required|string',
    ]);

    // Retourne les études correspondant au code_ensee
    $etudes = Etude::where('code_ensee', $request->code_ensee)
                    ->get(['id', 'numero_etude']); // on récupère id et numero_etude

    return response()->json($etudes);
}

}
