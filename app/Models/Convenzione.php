<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Convenzione extends Model
{
    protected $table = 'convenzioni';

    protected $fillable = [
        'titolo',
        'descrizione',
        'azienda',
        'sconto',
        'link',
    ];
}