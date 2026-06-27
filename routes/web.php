<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SubscriptionHistoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'home']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/portal', [PortalController::class, 'index'])->name('portal.index');
Route::post('/portal/check', [PortalController::class, 'check'])->name('portal.check');
Route::get('/portal/check', function () {
    return redirect()->route('portal.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [PlayerController::class, 'index'])->name('dashboard');
    Route::get('/players', [PlayerController::class, 'list'])->name('players.list');
    Route::get('/players/expired', [PlayerController::class, 'expiredSubscriptions'])->name('players.expired');
    Route::get('/players/{id}/profile', [PlayerController::class, 'profile'])->name('players.profile');
    Route::get('/heroes-wall', [PlayerController::class, 'heroesWall'])->name('heroes.wall');

    Route::get('/players/create', [PlayerController::class, 'create'])->name('players.create');
    Route::post('/api/players', [PlayerController::class, 'store'])->name('players.store');
    Route::post('/players/{id}/renew', [PlayerController::class, 'renew'])->name('players.renew');
    Route::get('/subscriptions/history', [SubscriptionHistoryController::class, 'index'])->name('subscriptions.history');

    Route::get('/reminders', [ReminderController::class, 'index'])->name('reminders.index');
    Route::post('/reminders/players/{id}/sent', [ReminderController::class, 'markSent'])->name('reminders.sent');
    Route::post('/reminders/players/{id}/dismiss', [ReminderController::class, 'dismiss'])->name('reminders.dismiss');

    Route::post('/players/{id}/evaluate', [PlayerController::class, 'evaluate'])->name('players.evaluate');
    Route::delete('/evaluations/videos/{id}', [PlayerController::class, 'deleteEvaluationVideo'])->name('evaluations.videos.delete');
    Route::post('/players/{id}/fights', [PlayerController::class, 'storeFight'])->name('players.fights.store');
    Route::post('/players/{id}/weights', [PlayerController::class, 'storeWeight'])->name('players.weights.store');
    Route::post('/players/{id}/tournaments', [PlayerController::class, 'storeTournament'])->name('players.tournaments.store');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
});
