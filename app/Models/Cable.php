<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cable extends Model
{
   protected $fillable = [
        'commande_id',
        'nom',
        'capacite_fo',
        'action',
        'commentaire'
    ];

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }
}
