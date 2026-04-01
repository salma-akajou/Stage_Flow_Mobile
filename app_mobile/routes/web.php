<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MobileLandingController;
use App\Http\Controllers\MobileOffreController;
use App\Http\Controllers\MobileEtudiantController;
use App\Http\Controllers\MobileCandidatureController;

// Landing Page
Route::get('/', [MobileLandingController::class, 'index'])->name('landing');

// Offres
Route::prefix('offres')->name('offres.')->group(function () {
    Route::get('/', [MobileOffreController::class, 'index'])->name('index');
    Route::get('/{id}', [MobileOffreController::class, 'show'])->name('show');
});

// Espace Étudiant
Route::prefix('student/{id}')->name('student.')->group(function () {
    Route::get('/dashboard', [MobileEtudiantController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [MobileEtudiantController::class, 'profile'])->name('profile');
    Route::get('/candidatures', [MobileCandidatureController::class, 'index'])->name('candidatures');
});
