<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/', function () {
    return view('acceuil');
});

Route::get('/inscription', [InscriptionController::class, 'formulaire']);
Route::post('/inscription', [InscriptionController::class, 'soumettre']);

Route::get('/attente', function () {
    return view('home');
});
 
// Route ADMIN
Route::prefix('admin')->middleware('is_admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('/users/{id}/approve', [DashboardController::class, 'approve'])->name('admin.approve');
    Route::post('/users/{id}/reject', [DashboardController::class, 'reject'])->name('admin.reject');
});

Route::get('/login', function () {
    return view('login');
});
