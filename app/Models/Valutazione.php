<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Valutazione extends Model
{
    protected $table = 'valutazioni';

    protected $fillable = [
        'dipendente_id',
        'categoria',
        'voto',
        'commento',
        'data',
    ];

    public function dipendente()
    {
        return $this->belongsTo(Dipendente::class);
    }
}