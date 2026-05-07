<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TurnoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FerieController;
use App\Models\Turno;
use App\Models\Ferie;
use App\Models\Dipendente;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {

    $totaleTurni = Turno::count();
    $totaleDipendenti = Dipendente::count();

    $ferieInAttesa = Ferie::where('stato', 'in_attesa')->count();
    $ferieApprovate = Ferie::where('stato', 'approvata')->count();
    $ferieRifiutate = Ferie::where('stato', 'rifiutata')->count();

    $ultimiTurni = Turno::with('dipendente')->latest()->take(5)->get();
    $ultimeFerie = Ferie::with('dipendente')->latest()->take(5)->get();

    return view('dashboard', compact(
        'totaleTurni',
        'totaleDipendenti',
        'ferieInAttesa',
        'ferieApprovate',
        'ferieRifiutate',
        'ultimiTurni',
        'ultimeFerie'
    ));

})->middleware(['auth', 'verified'])->name('dashboard');


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
});

require __DIR__.'/auth.php';