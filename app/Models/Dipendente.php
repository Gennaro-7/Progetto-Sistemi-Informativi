<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dipendente extends Model
{
    protected $table = 'dipendenti';

    protected $fillable = [
        'nome',
        'cognome',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}