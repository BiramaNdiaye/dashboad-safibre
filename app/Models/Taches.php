<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Model;



use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Taches extends Model

{

    protected $fillable = [

        'projet_reference',

        'type_taches_id',

        'informations',

    ];

    protected $casts = [

        'informations' => 'array', 

    ];



    public function projet(): BelongsTo

    {

        return $this->belongsTo(Projet::class, 'projet_reference', 'reference');

    }



    public function typeTache(): BelongsTo

    {

        return $this->belongsTo(TypeTache::class, 'type_taches_id');

    }



   

}

