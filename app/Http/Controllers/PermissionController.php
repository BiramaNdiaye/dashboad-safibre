<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        $roles = Role::all();
        return view('permissions.index', compact('permissions', 'roles'));
    }

    // Attribuer des permissions à un rôle
    public function store(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id', // Vérifier chaque permission
        ]);

        $role = Role::findOrFail($request->role_id);
        $role->syncPermissions($request->permissions); // Assigner les permissions au rôle

        return redirect()->route('permissions.index')->with('success', 'Permissions attribuées avec succès !');
    }
}
