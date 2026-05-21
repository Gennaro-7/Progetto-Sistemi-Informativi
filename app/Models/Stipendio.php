<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stipendio extends Model
{
    protected $table = 'stipendi';

    protected $fillable = [
        'dipendente_id',
        'mese',
        'anno',
        'file',
    ];

    public function dipendente()
    {
        return $this->belongsTo(Dipendente::class);
    }
}