<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EtudeFaisa extends Model
{
     use HasFactory;

    protected $fillable = [
        'commune',
        'code_postal',
        'code_ensei',
        'numero_etude',
       
    ];

    public function fcis()
{
    return $this->hasMany(FCINexloop::class, 'numero_etude', 'numero_etude');
}
}
