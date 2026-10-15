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
        'foto',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function turni()
    {
        return $this->hasMany(Turno::class);
    }

    public function ferie()
    {
        return $this->hasMany(Ferie::class);
    }

    public function stipendi()
    {
        return $this->hasMany(Stipendio::class);
    }

    public function documenti()
    {
        return $this->hasMany(Documento::class);
    }

    public function segnalazioni()
    {
        return $this->hasMany(Segnalazione::class);
    }

    public function valutazioni()
    {
        return $this->hasMany(Valutazione::class);
    }
}