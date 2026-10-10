<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
class ClientsController extends Controller
{
    public function index()
    {
        $clients=Client::all();
        return view('clients.index',compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'reference' => 'required|unique:clients,reference', 
            'telephone' => 'required|',
            'responsable' => 'required',
        ]);
    
        // Création du client
        Client::create($request->all());
    
        // Redirection avec un message de succès
        return redirect()->route('clients.index')->with('success', 'Client créé avec succès.');
    }
    
    public function edit($id)
    {
        
        $client = Client::findOrFail($id);
       
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, $id)
    {
        // Validation des données
        $request->validate([
            'nom' => 'required',
            'reference' => 'required|unique:clients,reference,' . $id, // validation de la référence unique, sauf pour l'ID actuel
            'telephone' => 'required',
            'responsable' => 'required',
        ]);
    
        // Trouver le client existant par ID
        $client = Client::findOrFail($id);
    
        // Mise à jour des données du client
        $client->update([
            'nom' => $request->input('nom'),
            'reference' => $request->input('reference'),
            'telephone' => $request->input('telephone'),
            'responsable' => $request->input('responsable'),
            'date_integration' => $request->input('date_integration'),
            'updated_at' => now(),
        ]);
    
        // Redirection avec un message de succès
        return redirect()->route('clients.index')->with('success', 'Client mis à jour avec succès.');
    }
    public function destroy($id)
{
    
    $client = Client::findOrFail($id);

    $client->delete();

    // Rediriger avec un message de succès
    return redirect()->route('clients.index')
        ->with('success', 'projet supprimé avec succès.');
}

}
