<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Liaison extends Model
{
    use HasFactory;

    protected $fillable = [
        'commande_element_id',
        'origine',
        'destination',
        'distance',
        'capacite_fo',
        'commentaire',
    ];

    public function commandeElement()
    {
        return $this->belongsTo(CommandeElement::class);
    }
}