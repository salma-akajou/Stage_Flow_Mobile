<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MobileLandingController;
use App\Http\Controllers\MobileOffreController;
use App\Http\Controllers\MobileEtudiantController;
use App\Http\Controllers\MobileCandidatureController;
use App\Http\Controllers\MobileAuthController;
use App\Http\Controllers\MobileFavoriController;

// Landing Page (publique)
Route::get('/', [MobileLandingController::class, 'index'])->name('landing');

// Authentification
Route::get('/login', [MobileAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [MobileAuthController::class, 'login'])->name('login.submit');
Route::get('/register', [MobileAuthController::class, 'showRegister'])->name('register');
Route::post('/register', [MobileAuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [MobileAuthController::class, 'logout'])->name('logout');

// Offres (publiques)
Route::prefix('offres')->name('offres.')->group(function () {
    Route::get('/', [MobileOffreController::class, 'index'])->name('index');
    Route::get('/{id}', [MobileOffreController::class, 'show'])->name('show');
});

// Espace Étudiant (protégé)
Route::prefix('student/{id}')->name('student.')->middleware('mobile.auth')->group(function () {
    Route::get('/dashboard', [MobileEtudiantController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [MobileEtudiantController::class, 'profile'])->name('profile');
    Route::get('/candidatures', [MobileCandidatureController::class, 'index'])->name('candidatures');
    Route::get('/favoris', [MobileFavoriController::class, 'index'])->name('favoris');
});
