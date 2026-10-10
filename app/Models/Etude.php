<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Etude extends Model
{
    use HasFactory;

    protected $fillable = [
        'code_ensee',
        'commune',
        'clients_id',
        'numero_etude',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'clients_id');
    }
}
