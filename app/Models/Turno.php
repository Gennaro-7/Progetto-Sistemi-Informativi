<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    protected $table = 'turni';

    protected $fillable = [
        'data',
        'turno',
        'dipendente_id',
        'note',
    ];

    public function dipendente()
    {
        return $this->belongsTo(Dipendente::class);
    }
}