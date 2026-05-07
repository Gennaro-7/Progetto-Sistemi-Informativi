<?php

namespace App\Http\Controllers;

use App\Models\Turno;
use App\Models\Dipendente;
use Illuminate\Http\Request;

class TurnoController extends Controller
{
    public function index()
{
    $user = auth()->user();

    if ($user->role === 'admin') {
        $turni = Turno::with('dipendente')->get();
    } else {
        $turni = Turno::with('dipendente')
            ->whereHas('dipendente', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->get();
    }

    $dipendenti = Dipendente::all();

    $events = $turni->map(function ($t) {
        $color = match ($t->turno) {
            'mattina' => '#22c55e',
            'pomeriggio' => '#f59e0b',
            'notte' => '#ef4444',
            default => '#3b82f6'
        };

        return [
            'id' => $t->id,
            'title' => $t->turno . ' - ' . optional($t->dipendente)->nome,
            'start' => $t->data,
            'backgroundColor' => $color,
            'borderColor' => $color,
        ];
    });

    return view('turni', compact('turni', 'events', 'dipendenti'));
}
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'data' => 'required|date',
            'turno' => 'required|string',
            'dipendente_id' => 'nullable|exists:dipendenti,id',
            'note' => 'nullable|string',
        ]);

        Turno::create([
            'data' => $request->data,
            'turno' => $request->turno,
            'dipendente_id' => $request->dipendente_id,
            'note' => $request->note,
        ]);

        return redirect()->route('turni');
    }

    public function edit(Turno $turno)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        return view('turni-edit', compact('turno'));
    }

    public function update(Request $request, Turno $turno)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'data' => 'required|date',
            'turno' => 'required|string',
            'dipendente_id' => 'nullable|exists:dipendenti,id',
            'note' => 'nullable|string',
        ]);

        $turno->update([
            'data' => $request->data,
            'turno' => $request->turno,
            'dipendente_id' => $request->dipendente_id,
            'note' => $request->note,
        ]);

        return redirect()->route('turni');
    }
}