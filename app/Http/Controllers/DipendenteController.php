<?php

namespace App\Http\Controllers;

use App\Models\Dipendente;
use App\Models\User;
use Illuminate\Http\Request;

class DipendenteController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $dipendenti = Dipendente::with('user')->get();
        $users = User::all();

        return view('dipendenti', compact('dipendenti', 'users'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'nome' => 'required|string',
            'cognome' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',
        ]);

        Dipendente::create([
            'nome' => $request->nome,
            'cognome' => $request->cognome,
            'user_id' => $request->user_id,
        ]);

        return redirect()->route('dipendenti');
    }
    public function destroy(Dipendente $dipendente)
{
    if (auth()->user()->role !== 'admin') {
        abort(403);
    }

    $dipendente->delete();

    return redirect()->route('dipendenti');
}
}