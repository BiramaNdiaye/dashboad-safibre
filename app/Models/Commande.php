<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
   protected $fillable = [
        'reference',
        'nom_site',
        'client_id',
        'user_id',
        'date_reception',
        'date_livraison',
        'statut',
        'description'
    ];
 public static function getStatuts()
    {
        return ['en_cours', 'livré', 'traité'];
    }
    
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sites()
    {
        return $this->hasMany(Site::class);
    }

    public function cables()
    {
        return $this->hasMany(Cable::class);
    }

    public function boites()
    {
        return $this->hasMany(Boite::class);
    }

    public function chambres()
    {
        return $this->hasMany(Chambre::class);
    }

    public function commandeElements()
{
    return $this->hasMany(CommandeElement::class);
}


}
