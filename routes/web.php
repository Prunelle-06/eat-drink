<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Entrepreneur\BoardController;
use App\Http\Controllers\ProductController;

// Route page acceuil
Route::get('/', function () {
    return view('acceuil');
});

// Routes inscription(demande de stand)
Route::get('/inscription', [InscriptionController::class, 'formulaire'])->name('register')->middleware('is_pending');
Route::post('/inscription', [InscriptionController::class, 'soumettre']);

// Routes Connexion
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);


Route::get('/attente', function () {
    return view('pending');
})->middleware(['auth', 'can:acces-attente']);
 
// Routes ADMIN
Route::prefix('admin')->middleware(['auth', 'is_admin', 'is_pending'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('/users/{id}/approve', [DashboardController::class, 'approve'])->name('admin.approve');
    Route::post('/users/{id}/reject', [DashboardController::class, 'reject'])->name('admin.reject');
});


Route::controller(ProductController::class)->group(function () {
    Route::get('/produits', 'index')->name('products.index');
    Route::get('/produits/create', 'create')->name('products.create');
    Route::post('/produits', 'store')->name('products.store');
});


Route::get('/dashboard', [BoardController::class, 'index']);


