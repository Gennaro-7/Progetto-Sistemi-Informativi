<?php

namespace App\Http\Controllers;

use App\Models\Dipendente;
use App\Models\Valutazione;
use Illuminate\Http\Request;

class ValutazioneController extends Controller
{
    public function index()
    {
        $dipendenti = Dipendente::all();

        $valutazioni = Valutazione::with('dipendente')
            ->latest()
            ->get();

        return view('valutazioni', compact(
            'dipendenti',
            'valutazioni'
        ));
    }
    public function store(Request $request)
{
    Valutazione::create([
        'dipendente_id' => $request->dipendente_id,
        'categoria' => $request->categoria,
        'voto' => $request->voto,
        'commento' => $request->commento,
        'data' => $request->data,
    ]);

    return back()->with('success', 'Valutazione aggiunta con successo');
}
public function update(Request $request, $id)
{
    $valutazione = Valutazione::findOrFail($id);

    $valutazione->update([
        'categoria' => $request->categoria,
        'voto' => $request->voto,
        'commento' => $request->commento,
        'data' => $request->data,
    ]);

    return back()->with('success', 'Valutazione aggiornata con successo');
}
public function destroy($id)
{
    Valutazione::findOrFail($id)->delete();

    return back()->with('success', 'Valutazione eliminata con successo');
}
}