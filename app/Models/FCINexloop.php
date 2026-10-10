<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class FCINexloop extends Model
{
   use HasFactory;

    protected $fillable = [
        'site', 
        'type',
        'numero_fci',
        'client'
        
       
    ];


  public function etudes()
    {
        return $this->belongsToMany(EtudeFaisa::class, 'code_ensei_etude');
    }
}
