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

// (Aucune référence à CheckRole ou IsAdminMiddleware n'est présente, donc rien à supprimer ici)

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

// Routes d'administration protégées par le middleware 'isadmin'
Route::get('/admin', function () {
    if (!auth()->check() || auth()->user()->role !== 'admin') {
        abort(403, 'Accès refusé.');
    }
    return view('admin.dashboard');
})->middleware('auth')->name('admin.dashboard');

// Gestion des demandes d'entrepreneurs par l'admin
Route::get('/admin/demandes', function () {
    if (!auth()->check() || auth()->user()->role !== 'admin') {
        abort(403, 'Accès refusé.');
    }
    return app(\App\Http\Controllers\AdminUserController::class)->index();
})->middleware('auth')->name('admin.demandes');

Route::post('/admin/demandes/{id}/statut', function ($id, \Illuminate\Http\Request $request) {
    if (!auth()->check() || auth()->user()->role !== 'admin') {
        abort(403, 'Accès refusé.');
    }
    return app(\App\Http\Controllers\AdminUserController::class)->updateStatut($request, $id);
})->middleware('auth')->name('admin.demandes.update');

require __DIR__.'/auth.php';