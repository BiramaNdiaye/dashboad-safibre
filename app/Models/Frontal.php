<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
class Frontal extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_projet', 'statut_fci', 'date_declaration',
        'numero_fci', 'numero_fci_annulation', 'reference'
    ];

    protected $casts = [
        'date_declaration' => 'date',
    ];

    public function etudes()
    {
        return $this->belongsToMany(Etude::class, 'frontal_etude');
    }

    public function projet()
    {
        return $this->belongsTo(Projet::class, 'reference', 'reference');
    }
}
