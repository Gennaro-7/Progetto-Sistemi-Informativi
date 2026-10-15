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

$users = User::where('role', '!=', 'admin')->get();

$utentiInAttesa = User::where('role', '!=', 'admin')
    ->whereNotIn('id', Dipendente::whereNotNull('user_id')->pluck('user_id'))
    ->get();

return view('dipendenti', compact('dipendenti', 'users', 'utentiInAttesa'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'nome' => 'required|string',
            'cognome' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id|unique:dipendenti,user_id',
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
    \App\Models\Turno::where('dipendente_id', $dipendente->id)->delete();
    \App\Models\Ferie::where('dipendente_id', $dipendente->id)->delete();
    
    $dipendente->delete();

    return redirect()->route('dipendenti');
}
}