<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\DashboardController;

// Route page acceuil
Route::get('/', function () {
    return view('acceuil');
});

// Routes inscription(demende de stand)
Route::get('/inscription', [InscriptionController::class, 'formulaire'])->name('register');
Route::post('/inscription', [InscriptionController::class, 'soumettre']);

// Routes Connexion
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);


Route::get('/attente', function () {
    return view('home');
});
 
// Route ADMIN
Route::prefix('admin')->middleware('is_admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('/users/{id}/approve', [DashboardController::class, 'approve'])->name('admin.approve');
    Route::post('/users/{id}/reject', [DashboardController::class, 'reject'])->name('admin.reject');
});

