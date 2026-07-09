<?php

namespace App\Http\Controllers;

use App\Models\Dipendente;
use App\Models\Documento;
use App\Models\Ferie;
use App\Models\Turno;
use App\Models\Segnalazione;
use App\Models\Valutazione;

class ProfiloDipendenteController extends Controller
{
    public function show($id)
    {
        $dipendente = Dipendente::with('user')->findOrFail($id);

        $totaleDocumenti = Documento::where('dipendente_id', $id)->count();
        $totaleFerie = Ferie::where('dipendente_id', $id)->count();
        $totaleTurni = Turno::where('dipendente_id', $id)->count();
        $totaleSegnalazioni = Segnalazione::where('dipendente_id', $id)->count();

        $valutazioni = Valutazione::where('dipendente_id', $id)
            ->latest()
            ->get();

        $mediaValutazioni = Valutazione::where('dipendente_id', $id)
            ->avg('voto');

        return view('profilo-dipendente', compact(
            'dipendente',
            'totaleDocumenti',
            'totaleFerie',
            'totaleTurni',
            'totaleSegnalazioni',
            'valutazioni',
            'mediaValutazioni'
        ));
    }
}