<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class patatoide extends Model
{
     use HasFactory;

    protected $fillable = [
        'type_projet',
        'ref_projet',
        'site',
        'date_reception',
        'nbre_bpe',
        'nbre_client',
        'nbre_cable_ext',
        'nbre_racco_client',
        'statut_patatoide',
        'date_liv_patatoide',
        'validation_covage',
        'commentaires',
        'users_id',
    ];
    protected $casts = [
        'date_liv_patatoide' => 'date',
        'date_reception' => 'date',

    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
