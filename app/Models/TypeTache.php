<?php

namespace App\Models;
use App\Models\Taches;
use Illuminate\Database\Eloquent\Model;

class TypeTache extends Model
{
    protected $fillable = ['nom', 'description'];
    public function taches()
    {
        return $this->hasMany(Taches::class);
    }
}
