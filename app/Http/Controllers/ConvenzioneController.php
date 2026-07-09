<?php

namespace App\Http\Controllers;

use App\Models\Convenzione;
use Illuminate\Http\Request;

class ConvenzioneController extends Controller
{
    public function index()
    {
        $convenzioni = Convenzione::latest()->get();

        return view('convenzioni', compact('convenzioni'));
    }

    public function destroy($id)
{
    Convenzione::findOrFail($id)->delete();

    return back()->with('success', 'Convenzione eliminata con successo');
}

    public function store(Request $request)
    {
        Convenzione::create([
            'titolo' => $request->titolo,
            'descrizione' => $request->descrizione,
            'azienda' => $request->azienda,
            'sconto' => $request->sconto,
            'link' => $request->link,
        ]);

        return back()->with('success', 'Convenzione aggiunta con successo');
    }

    public function edit($id)
{
    $convenzione = Convenzione::findOrFail($id);

    return view('modifica-convenzione', compact('convenzione'));
}

public function update(Request $request, $id)
{
    $convenzione = Convenzione::findOrFail($id);

    $convenzione->update([
        'titolo' => $request->titolo,
        'descrizione' => $request->descrizione,
        'azienda' => $request->azienda,
        'sconto' => $request->sconto,
        'link' => $request->link,
    ]);

    return redirect()
        ->route('convenzioni')
        ->with('success', 'Convenzione aggiornata con successo');
}
}