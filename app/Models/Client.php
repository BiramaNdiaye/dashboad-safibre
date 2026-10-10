<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'nom',
        'reference',
        'telephone', 'date_integration', 'responsable'
    ];

    public function projets()
    {
        return $this->hasMany(Projet::class, 'clients_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'clients_id');
    }
    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }
}
