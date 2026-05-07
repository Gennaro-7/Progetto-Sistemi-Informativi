<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ferie extends Model
{
    protected $table = 'ferie';

    protected $fillable = [
        'dipendente_id',
        'data_inizio',
        'data_fine',
        'motivo',
        'stato',
    ];

    public function dipendente()
    {
        return $this->belongsTo(Dipendente::class);
    }
}