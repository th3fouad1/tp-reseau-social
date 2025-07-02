<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\IaController;
use App\Http\Controllers\InvitationController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/login', [UtilisateurController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UtilisateurController::class, 'login']);
Route::get('/register', [UtilisateurController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [UtilisateurController::class, 'register']);
Route::post('/logout', [UtilisateurController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/ia', [IaController::class, 'form'])->name('ia.form');
    Route::post('/ia', [IaController::class, 'handle'])->name('ia.handle');
    Route::get('/ia/history', [IaController::class, 'history'])->name('ia.history');

    Route::get('/utilisateurs/profile', [UtilisateurController::class, 'profile'])->name('utilisateurs.profile');
    Route::put('/utilisateurs/profile', [UtilisateurController::class, 'updateProfile'])->name('utilisateurs.profile.update');
    Route::delete('/utilisateurs/profile', [UtilisateurController::class, 'destroyProfile'])->name('utilisateurs.profile.destroy');

    Route::get('/invitations', [InvitationController::class, 'index'])->name('invitations.index');
    Route::get('/invitations/create', [InvitationController::class, 'create'])->name('invitations.create');
    Route::post('/invitations', [InvitationController::class, 'store'])->name('invitations.store');
    Route::get('/invitations/{id}/edit', [InvitationController::class, 'edit'])->name('invitations.edit');
    Route::put('/invitations/{id}', [InvitationController::class, 'update'])->name('invitations.update');
    Route::delete('/invitations/{id}', [InvitationController::class, 'destroy'])->name('invitations.destroy');
    Route::post('/invitations/{id}/accept', [InvitationController::class, 'accept'])->name('invitations.accept');
    Route::post('/invitations/{id}/reject', [InvitationController::class, 'reject'])->name('invitations.reject');
});