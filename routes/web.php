<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StandController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\CommandeController;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Ajoute ici toutes les routes d'administration (gestion utilisateurs, approbation, etc.)
    // Exemples :
    // Route::get('/admin/utilisateurs', [AdminController::class, 'users'])->name('admin.users');
    // Route::post('/admin/approve/{user}', [AdminController::class, 'approve'])->name('admin.approve');
});

// Les autres routes (stands, produits, commandes, etc.) restent protégées par 'auth' ou par des vérifications dans les contrôleurs.

Route::get('/test-role', function () {
    if (auth()->user()->role !== 'admin') {
        abort(403, 'Accès refusé.');
    }
    return 'OK';
});

// Route de test pour vérifier l'authentification
Route::get('/test-auth', function () {
    if (!auth()->check()) {
        return 'Non connecté';
    }
    return 'Connecté en tant que: ' . auth()->user()->name . ' (Rôle: ' . auth()->user()->role . ')';
});

Route::resource('stands', StandController::class);
Route::resource('produits', ProduitController::class);
Route::resource('commandes', CommandeController::class);

// Route pour mettre à jour le statut d'une commande
Route::patch('/commandes/{commande}/statut', [CommandeController::class, 'updateStatut'])->name('commandes.update-statut');

// Route AJAX pour récupérer les produits d'un stand
Route::get('/api/stands/{stand}/produits', function ($standId, Request $request) {
    return \App\Models\Produit::where('stand_id', $standId)->get();
});

require __DIR__.'/auth.php';