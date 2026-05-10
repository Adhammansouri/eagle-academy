<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PortalController;
Route::get('/', function () {
    return view('login');
});
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/dashboard', [PlayerController::class, 'index'])->name('dashboard');
Route::get('/players', [PlayerController::class, 'list'])->name('players.list');
Route::get('/players/create', [PlayerController::class, 'create'])->name('players.create');
Route::post('/api/players', [PlayerController::class, 'store'])->name('players.store');
Route::post('/players/{id}/evaluate', [PlayerController::class, 'evaluate'])->name('players.evaluate');
Route::get('/players/{id}/profile', [PlayerController::class, 'profile'])->name('players.profile');
Route::post('/players/{id}/fights', [PlayerController::class, 'storeFight'])->name('players.fights.store');
Route::post('/players/{id}/weights', [PlayerController::class, 'storeWeight'])->name('players.weights.store');
Route::post('/players/{id}/tournaments', [PlayerController::class, 'storeTournament'])->name('players.tournaments.store');
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

Route::get('/portal', [PortalController::class, 'index'])->name('portal.index');
Route::post('/portal/check', [PortalController::class, 'check'])->name('portal.check');
Route::get('/portal/check', function () {
    return redirect()->route('portal.index');
});
