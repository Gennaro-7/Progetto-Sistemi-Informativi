<?php

namespace App\Http\Controllers;

use App\Models\Dipendente;
use App\Models\Stipendio;
use Illuminate\Http\Request;

class StipendioController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {

            $stipendi = Stipendio::with('dipendente')->latest()->get();

            $dipendenti = Dipendente::all();

        } else {

            $dipendente = Dipendente::where('user_id', $user->id)->first();

            $stipendi = Stipendio::where('dipendente_id', optional($dipendente)->id)
                ->latest()
                ->get();

            $dipendenti = [];
        }

        return view('stipendi', compact('stipendi', 'dipendenti'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'dipendente_id' => 'required',
            'mese' => 'required',
            'anno' => 'required',
            'file' => 'required|mimes:pdf|max:2048',
        ]);

        $path = $request->file('file')->store('stipendi', 'public');

        Stipendio::create([
            'dipendente_id' => $request->dipendente_id,
            'mese' => $request->mese,
            'anno' => $request->anno,
            'file' => $path,
        ]);

        return redirect()->route('stipendi');
    }
}