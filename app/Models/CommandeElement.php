<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommandeElement extends Model
{
    protected $fillable = [
        'commande_id',
        'type',
        'nom',
        'action',
        'ancien_nom',
        'origine',
        'destination',
        'capacite_fo',
        'commentaire',
    ];

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    public function liaisons()
    {
        return $this->hasMany(Liaison::class);
    }
}