<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TurnoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FerieController;
use App\Models\Turno;
use App\Models\Ferie;
use App\Models\Dipendente;
use App\Http\Controllers\DipendenteController;
use App\Http\Controllers\StipendioController;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {

    $user = auth()->user();

    if ($user->role === 'admin') {

        $totaleDipendenti = \App\Models\Dipendente::count();
        $totaleTurni = \App\Models\Turno::count();

        $ferieInAttesa = \App\Models\Ferie::where('stato', 'in_attesa')->count();
        $ferieApprovate = \App\Models\Ferie::where('stato', 'approvata')->count();
        $ferieRifiutate = \App\Models\Ferie::where('stato', 'rifiutata')->count();

        $totaleStipendi = \App\Models\Stipendio::count();

        $ultimiTurni = \App\Models\Turno::with('dipendente')->latest()->take(5)->get();
        $ultimeFerie = \App\Models\Ferie::with('dipendente')->latest()->take(5)->get();

    } else {

        $dipendente = \App\Models\Dipendente::where('user_id', $user->id)->first();

        $totaleDipendenti = null;

        $totaleTurni = \App\Models\Turno::where('dipendente_id', optional($dipendente)->id)->count();

        $ferieInAttesa = \App\Models\Ferie::where('dipendente_id', optional($dipendente)->id)
            ->where('stato', 'in_attesa')
            ->count();

        $ferieApprovate = \App\Models\Ferie::where('dipendente_id', optional($dipendente)->id)
            ->where('stato', 'approvata')
            ->count();

        $ferieRifiutate = \App\Models\Ferie::where('dipendente_id', optional($dipendente)->id)
            ->where('stato', 'rifiutata')
            ->count();

        $totaleStipendi = \App\Models\Stipendio::where('dipendente_id', optional($dipendente)->id)->count();

        $ultimiTurni = \App\Models\Turno::where('dipendente_id', optional($dipendente)->id)
            ->latest()
            ->take(5)
            ->get();

        $ultimeFerie = \App\Models\Ferie::where('dipendente_id', optional($dipendente)->id)
            ->latest()
            ->take(5)
            ->get();
    }

    return view('dashboard', compact(
        'totaleDipendenti',
        'totaleTurni',
        'ferieInAttesa',
        'ferieApprovate',
        'ferieRifiutate',
        'totaleStipendi',
        'ultimiTurni',
        'ultimeFerie'
    ));

})->middleware(['auth'])->name('dashboard');


Route::middleware('auth')->group(function () {

    Route::get('/calendario', function () {
        return view('calendario');
    })->name('calendario');

    // 🔥 ORA TURNI PASSA DAL CONTROLLER
    Route::get('/turni', [TurnoController::class, 'index'])->name('turni');

    Route::get('/ferie', function () {
        return view('ferie');
    })->name('ferie');

    Route::get('/stipendi', function () {
        return view('stipendi');
    })->name('stipendi');

    Route::get('/convenzioni', function () {
        return view('convenzioni');
    })->name('convenzioni');

    Route::get('/segnalazioni', function () {
        return view('segnalazioni');
    })->name('segnalazioni');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/turni', [TurnoController::class, 'store'])->name('turni.store');
    Route::get('/turni/{turno}/edit', [TurnoController::class, 'edit'])->name('turni.edit');
    Route::put('/turni/{turno}', [TurnoController::class, 'update'])->name('turni.update');
    Route::get('/ferie', [FerieController::class, 'index'])->name('ferie');
    Route::post('/ferie', [FerieController::class, 'store'])->name('ferie.store');
    Route::put('/ferie/{ferie}/approva', [FerieController::class, 'approva'])->name('ferie.approva');
    Route::put('/ferie/{ferie}/rifiuta', [FerieController::class, 'rifiuta'])->name('ferie.rifiuta');
    Route::get('/dipendenti', [DipendenteController::class, 'index'])->name('dipendenti');
    Route::post('/dipendenti', [DipendenteController::class, 'store'])->name('dipendenti.store');
    Route::get('/stipendi', [StipendioController::class, 'index'])->name('stipendi');
    Route::post('/stipendi', [StipendioController::class, 'store'])->name('stipendi.store');
    Route::get('/stipendi/{stipendio}/download', [StipendioController::class, 'download'])->name('stipendi.download');
    Route::delete('/dipendenti/{dipendente}', [DipendenteController::class, 'destroy'])->name('dipendenti.destroy');
});
Route::get('/calendar-events', function () {

    $eventi = [];

    $tipo = request('tipo', 'tutti');
    $dipendenteFiltro = request('dipendente', 'tutti');

    if ($tipo === 'tutti' || $tipo === 'turni') {

        $turni = \App\Models\Turno::with('dipendente');

        if ($dipendenteFiltro !== 'tutti') {
            $turni->where('dipendente_id', $dipendenteFiltro);
        }

        $turni = $turni->get();

        foreach ($turni as $turno) {

            $dipendente = $turno->dipendente;

            $nomeCompleto = $dipendente
                ? trim($dipendente->nome . ' ' . $dipendente->cognome)
                : 'Dipendente non assegnato';

            $dipendenteId = $dipendente ? $dipendente->id : 'N/D';

            $color = match ($turno->turno) {
                'mattina' => '#22c55e',
                'pomeriggio' => '#f97316',
                'notte' => '#4c1d95',
                default => '#6b7280',
            };

            $eventi[] = [
                'id' => 'turno-' . $turno->id,
                'title' => 'ID' . $dipendenteId . ' - ' . $turno->turno . ' - ' . $nomeCompleto,
                'start' => $turno->data,
                'color' => $color,
            ];
        }
    }

    if ($tipo === 'tutti' || $tipo === 'ferie') {

        $ferie = \App\Models\Ferie::with('dipendente')
            ->where('stato', 'approvata');

        if ($dipendenteFiltro !== 'tutti') {
            $ferie->where('dipendente_id', $dipendenteFiltro);
        }

        $ferie = $ferie->get();

        foreach ($ferie as $f) {

            $dipendente = $f->dipendente;

            $nomeCompleto = $dipendente
                ? trim($dipendente->nome . ' ' . $dipendente->cognome)
                : 'Dipendente non assegnato';

            $dipendenteId = $dipendente ? $dipendente->id : 'N/D';

            $eventi[] = [
                'id' => 'ferie-' . $f->id,
                'title' => 'Ferie ID' . $dipendenteId . ' - ' . $nomeCompleto,
                'start' => $f->data_inizio,
                'end' => date('Y-m-d', strtotime($f->data_fine . ' +1 day')),
                'color' => '#16a34a',
            ];
        }
    }

    return response()->json($eventi);

})->middleware('auth');

Route::get('/calendario', function () {
    return view('calendario');
})->middleware('auth')->name('calendario');

Route::post('/calendar-turno', function (\Illuminate\Http\Request $request) {

    \App\Models\Turno::create([
        'dipendente_id' => $request->dipendente_id,
        'data' => $request->data,
        'turno' => $request->turno,
    ]);

    return response()->json([
        'success' => true
    ]);

})->middleware('auth');
Route::put('/calendar-update-turno/{id}', function (
    \Illuminate\Http\Request $request,
    $id
) {

    $turno = \App\Models\Turno::findOrFail($id);

    $turno->update([
        'turno' => $request->turno
    ]);

    return response()->json([
        'success' => true
    ]);

})->middleware('auth');
Route::delete('/calendar-delete-turno/{id}', function ($id) {

    \App\Models\Turno::findOrFail($id)->delete();

    return response()->json([
        'success' => true
    ]);

})->middleware('auth');
Route::put('/calendar-update-turno/{id}', function (
    \Illuminate\Http\Request $request,
    $id
) {

    $turno = \App\Models\Turno::findOrFail($id);

    $turno->update([
        'turno' => $request->turno
    ]);

    return response()->json([
        'success' => true
    ]);

})->middleware('auth');
Route::delete('/calendar-delete-turno/{id}', function ($id) {

    \App\Models\Turno::findOrFail($id)->delete();

    return response()->json([
        'success' => true
    ]);

})->middleware('auth');
Route::get('/segnalazioni', function () {

    $user = auth()->user();

    if ($user->role === 'admin') {

        $segnalazioni = \App\Models\Segnalazione::with('dipendente')
            ->latest()
            ->get();

    } else {

        $dipendente = \App\Models\Dipendente::where(
            'user_id',
            $user->id
        )->first();

        $segnalazioni = \App\Models\Segnalazione::where(
            'dipendente_id',
            optional($dipendente)->id
        )->latest()->get();
    }

    return view('segnalazioni', compact('segnalazioni'));

})->middleware('auth')->name('segnalazioni');


Route::post('/segnalazioni', function (\Illuminate\Http\Request $request) {

    $dipendente = \App\Models\Dipendente::where(
        'user_id',
        auth()->id()
    )->first();

    \App\Models\Segnalazione::create([
        'dipendente_id' => optional($dipendente)->id,
        'titolo' => $request->titolo,
        'descrizione' => $request->descrizione,
        'stato' => 'aperta',
    ]);

    return redirect()->route('segnalazioni');

})->middleware('auth')->name('segnalazioni.store');
Route::put('/segnalazioni/{id}/stato', function (
    \Illuminate\Http\Request $request,
    $id
) {

    $segnalazione = \App\Models\Segnalazione::findOrFail($id);

    $segnalazione->update([
        'stato' => $request->stato
    ]);

    return back();

})->middleware('auth')->name('segnalazioni.stato');

require __DIR__.'/auth.php';