<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StandController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Entrepreneur\BoardController;
use App\Http\Controllers\Visitor\BoardVisitorController;
use App\Http\Controllers\ProductController;

// Route page acceuil
Route::get('/', function () {
    return view('acceuil');
})->name('home');

// Routes inscription
Route::get('/inscription', [InscriptionController::class, 'create'])->name('register');
Route::post('/inscription', [InscriptionController::class, 'store']);

// Routes Connexion
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Route de déconnexion
Route::post('/logout', function(Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    $request->session()->regenerate();

    return redirect()->route('login')->with('success', 'Déconnexion réussie');
})->middleware('auth')->name('logout');


Route::get('/attente', function () {
    return view('pending');
});
 
// Routes ADMIN
Route::prefix('admin')->middleware(['auth', 'is_admin', 'is_pending'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('/users/{id}/approve', [DashboardController::class, 'approve'])->name('admin.approve');
    Route::post('/users/{id}/reject', [DashboardController::class, 'reject'])->name('admin.reject');
});


// Route page produits
Route::controller(ProductController::class)->group(function () {
    Route::get('/produits/create', 'create')->name('products.create');
    Route::post('/produits', 'store')->name('products.store');
    Route::get('/products/{product}/edit','edit')->name('products.edit'); 
    Route::put('/products/{product}/update','update')->name('products.update'); 
    Route::delete('/products/{product}','destroy')->name('products.destroy'); 
});

// Dashboard exposant
Route::get('/dashboard/exposant', [BoardController::class, 'index'])->name('dashboard.exposant');
Route::get('/dashboard/exposant/profil', [BoardController::class, 'profil'])->name('dashboard.exposant.profil');
Route::put('/dashboard/exposant/profil', [BoardController::class, 'updateProfil'])->name('dashboard.exposant.updateProfil');
// Route::get('/dashboard', [BoardController::class, 'show'])->name('dashboard.stand.show');

// Dashboard Visiteur
Route::middleware('auth')->controller(BoardVisitorController::class)->group(function () {

    Route::get('/dashboard/visiteur', 'index')->name('dashboard.visiteur');
    Route::get('/dashboard/visiteur/profil', 'profil')->name('dashboard.visiteur.profil');
    
    Route::put('/dashboard/visiteur/profil', 'updateProfil')->name('dashboard.visiteur.updateProfil');
});

Route::get('/stands', [StandController::class, 'index'])->name('stands.index');
Route::get('/stands/{stand}', [StandController::class, 'show'])->name('stands.show');


// Routes pour les commandes
Route::middleware('auth')->controller(OrderController::class)->group(function () {

    Route::post('/orders', 'store')->name('orders.store');
    Route::get('/orders/{order}', 'show')->name('orders.show');
    
    Route::patch('/orders/{order}/status', 'updateStatus')->name('orders.update-status');
});


