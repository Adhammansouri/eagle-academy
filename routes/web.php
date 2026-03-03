<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return view('login');
});

Route::get('/dashboard', [PlayerController::class, 'index'])->name('dashboard');
Route::get('/players', [PlayerController::class, 'list'])->name('players.list');
Route::get('/players/create', [PlayerController::class, 'create'])->name('players.create');
Route::post('/api/players', [PlayerController::class, 'store'])->name('players.store');
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
