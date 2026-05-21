<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Segnalazione extends Model
{
    protected $table = 'segnalazioni';

    protected $fillable = [
        'dipendente_id',
        'titolo',
        'descrizione',
        'stato',
    ];

    public function dipendente()
    {
        return $this->belongsTo(Dipendente::class);
    }
}