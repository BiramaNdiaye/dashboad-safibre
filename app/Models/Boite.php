<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Boite extends Model
{
  protected $fillable = [
        'commande_id',
        'nom',
        'action',
        'commentaire'
    ];

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }
}
