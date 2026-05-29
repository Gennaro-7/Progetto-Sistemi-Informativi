<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $table = 'documenti';

    protected $fillable = [
        'dipendente_id',
        'titolo',
        'file',
    ];

    public function dipendente()
    {
        return $this->belongsTo(Dipendente::class);
    }
}