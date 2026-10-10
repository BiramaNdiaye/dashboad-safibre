<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
class RoleController extends Controller
{

    
    public function assignRole()
    {
        $users = User::all();
        $roles = Role::all();
        return view('roles.assign', compact('users', 'roles'));
    }

    public function storeRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::findOrFail($request->user_id);
        $user->syncRoles([$request->role]); // Remplace les anciens rôles

        return redirect()->back()->with('success', 'Rôle assigné avec succès !');
    }
}
