<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      
        Permission::create(['name' => 'créer utilisateur']);
        Permission::create(['name' => 'modifier utilisateur']);
        Permission::create(['name' => 'supprimer utilisateur']);
        Permission::create(['name' => 'créer projet']);
        Permission::create(['name' => 'voir projet']);
        Permission::create(['name' => 'modifier projet']);
        Permission::create(['name' => 'supprimer projet']);
        Permission::create(['name' => 'voir tache']);
        Permission::create(['name' => 'creer tache']);
        Permission::create(['name' => 'modifier tache']);
        Permission::create(['name' => 'supprimer tache']);

        // Création des rôles et assignation des permissions
        $admin = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);
        $clientRole = Role::create(['name' => 'client']);

        // Attribution des permissions aux rôles
        $admin->givePermissionTo(Permission::all());
        
    }
}
