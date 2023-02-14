<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\DashController;
use App\Http\Controllers\InvitationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    if(auth()->check()) return redirect()->route('dash');
    return view('home');
});

Route::get('/invitation/{invitation:slug}', [InvitationController::class, 'show']);

Route::redirect('/login', '/auth/redirect')->name('login');
Route::get('/auth/redirect', [AuthController::class, 'redirect'])->name('auth.redirect');
Route::get('/auth/callback', [AuthController::class, 'callback'])->name('auth.callback');

Route::middleware('auth')->group(function() {
    Route::get('/dash', [DashController::class, 'index'])->name('dash');

    Route::post('/invitations', [InvitationController::class, 'store']);
    Route::delete('/invitations/{invitation:slug}', [InvitationController::class, 'destroy']);

    Route::post('/api/accept-invitation', [InvitationController::class, 'accept']);
    Route::get('/api/calendars', [CalendarController::class, 'list']);
    Route::get('/api/events', [CalendarController::class, 'events']);
});