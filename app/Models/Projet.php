<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Projet extends Model
{
    use HasFactory;
    protected $fillable = ["users_id","clients_id", "reference","nom_site", "date_commande", "date_livraison", "statut_projet", "type_projet", "commentaires","code_site"];

    public function taches()
    {
        return $this->hasMany(Taches::class, 'projet_reference', 'reference');
    }

    public function chefProjet(): BelongsTo
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function client():BelongsTo
    {
        return $this->belongsTo(Client::class, 'clients_id');
    }
    
}
