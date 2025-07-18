<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('acceuil');
});
use App\Http\Controllers\InscriptionController;

Route::get('/inscription', [InscriptionController::class, 'formulaire']);
Route::post('/inscription', [InscriptionController::class, 'soumettre']);

Route::get('/attente', function () {
    return view('home');
});
 
Route::get('/admin', function () {
    return view('admin');
});

 
Route::get('/login', function () {
    return view('login');
});
