<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Client;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function assignRole($userId, $roleName)
{
    $user = User::findOrFail($userId);
    $roles = Role::where('name', $roleName)->first();
  
    if ($role) {
        $user->assignRole($role);
        return "Rôle {$roleName} attribué à l'utilisateur.";
    }

    return "Rôle non trouvé.";
}
    public function index()
    {
        $users=User::all();
        return view('users.index' , compact('users'));
}
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        {
            $roles = Role::all();
            $clients=Client::all();
            return view('users.create', compact('roles', 'clients'));
        }
    }

    public function store(Request $request)
{
    // Validation des données
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'role' => 'required|exists:roles,name', // Vérifie que le rôle existe
        'clients_id' => 'nullable|exists:clients,id',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    // Données de base pour la création de l'utilisateur
    $userData = [
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ];

    // Associer le client_id uniquement si le rôle est "client"
    if ($request->role === 'client') {
        $userData['clients_id'] = $request->clients_id;
    }

    // Créer l'utilisateur
    $user = User::create($userData);

    // Attribuer le rôle sélectionné
    $role = Role::findByName($request->role);
    $user->assignRole($role);

    // Rediriger avec un message de succès
    return redirect()->route('users.index')
        ->with('success', 'Utilisateur créé avec succès.');
}
  

    public function edit($id)
    {
        $roles = Role::all();
        $user = User::findOrFail($id);
        return view('users.edit', compact('user','roles'));
    }
    public function update(Request $request, $id)
    {
        
        $user = User::findOrFail($id);
    
      
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id, 
            'password' => 'nullable|string|min:8|confirmed', 
            'role' => 'required|exists:roles,name', 
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    
       
        $user->name = $request->name;
        $user->email = $request->email;
    
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
    
        $user->save();
    
      
        $role = Role::findByName($request->role);
        $user->syncRoles([$role]);
    
        return redirect()->route('users.index')
            ->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function destroy($id)
{
    // Trouver l'utilisateur à supprimer
    $user = User::findOrFail($id);

    // Supprimer l'utilisateur
    $user->delete();

    // Rediriger avec un message de succès
    return redirect()->route('users.index')
        ->with('success', 'Utilisateur supprimé avec succès.');
}
    
}
