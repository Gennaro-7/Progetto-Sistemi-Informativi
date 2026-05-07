<?php

namespace App\Http\Controllers;

use App\Models\Ferie;
use App\Models\Dipendente;
use Illuminate\Http\Request;

class FerieController extends Controller
{
    public function index()
{
    $user = auth()->user();

    if ($user->role === 'admin') {
        $ferie = Ferie::with('dipendente')->get();
    } else {
        $ferie = Ferie::with('dipendente')
            ->whereHas('dipendente', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->get();
    }

    $dipendenti = Dipendente::all();

    return view('ferie', compact('ferie', 'dipendenti'));
}
    public function store(Request $request)
{
    if (auth()->user()->role === 'admin') {
        $request->validate([
            'dipendente_id' => 'required|exists:dipendenti,id',
            'data_inizio' => 'required|date',
            'data_fine' => 'required|date|after_or_equal:data_inizio',
            'motivo' => 'nullable|string',
        ]);

        $dipendenteId = $request->dipendente_id;
    } else {
        $request->validate([
            'data_inizio' => 'required|date',
            'data_fine' => 'required|date|after_or_equal:data_inizio',
            'motivo' => 'nullable|string',
        ]);

        $dipendente = \App\Models\Dipendente::where('user_id', auth()->id())->first();

        if (!$dipendente) {
            abort(403, 'Il tuo account non è collegato a un dipendente.');
        }

        $dipendenteId = $dipendente->id;
    }

    Ferie::create([
        'dipendente_id' => $dipendenteId,
        'data_inizio' => $request->data_inizio,
        'data_fine' => $request->data_fine,
        'motivo' => $request->motivo,
        'stato' => 'in_attesa',
    ]);

    return redirect()->route('ferie');
}
    public function approva(Ferie $ferie)
{
    if (auth()->user()->role !== 'admin') {
        abort(403);
    }

    $ferie->update([
        'stato' => 'approvata',
    ]);

    return redirect()->route('ferie');
}

public function rifiuta(Ferie $ferie)
{
    if (auth()->user()->role !== 'admin') {
        abort(403);
    }

    $ferie->update([
        'stato' => 'rifiutata',
    ]);

    return redirect()->route('ferie');
}
}