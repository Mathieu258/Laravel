<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StandController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\AdminCommandeController;
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

// Gestion des commandes par l'admin
Route::get('/admin/commandes', function () {
    if (!auth()->check() || auth()->user()->role !== 'admin') {
        abort(403, 'Accès refusé.');
    }
    return app(\App\Http\Controllers\AdminCommandeController::class)->index(request());
})->middleware('auth')->name('admin.commandes');

Route::get('/admin/commandes/{commande}', function ($commande) {
    if (!auth()->check() || auth()->user()->role !== 'admin') {
        abort(403, 'Accès refusé.');
    }
    return app(\App\Http\Controllers\AdminCommandeController::class)->show($commande);
})->middleware('auth')->name('admin.commandes.show');

Route::patch('/admin/commandes/{commande}/statut', function ($commande, \Illuminate\Http\Request $request) {
    if (!auth()->check() || auth()->user()->role !== 'admin') {
        abort(403, 'Accès refusé.');
    }
    return app(\App\Http\Controllers\AdminCommandeController::class)->updateStatus($request, $commande);
})->middleware('auth')->name('admin.commandes.update-status');

Route::get('/admin/commandes/export', function (\Illuminate\Http\Request $request) {
    if (!auth()->check() || auth()->user()->role !== 'admin') {
        abort(403, 'Accès refusé.');
    }
    return app(\App\Http\Controllers\AdminCommandeController::class)->export($request);
})->middleware('auth')->name('admin.commandes.export');

// Routes publiques (accessibles à tous)
Route::prefix('public')->group(function () {
    // Liste des stands approuvés
    Route::get('/stands', [App\Http\Controllers\PublicController::class, 'index'])->name('public.stands.index');
    
    // Détails d'un stand
    Route::get('/stands/{id}', [App\Http\Controllers\PublicController::class, 'show'])->name('public.stands.show');
    
    // Recherche de produits
    Route::get('/produits/search', [App\Http\Controllers\PublicController::class, 'searchProduits'])->name('public.produits.search');
    
    // Statistiques publiques
    Route::get('/stats', [App\Http\Controllers\PublicController::class, 'stats'])->name('public.stats');
});

// Routes du panier
Route::prefix('cart')->group(function () {
    Route::get('/', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/add', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    Route::put('/update', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::delete('/remove/{produitId}', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/clear', [App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');
    Route::get('/count', [App\Http\Controllers\CartController::class, 'count'])->name('cart.count');
});

// Routes des commandes publiques
Route::prefix('orders')->group(function () {
    Route::get('/checkout', [App\Http\Controllers\PublicOrderController::class, 'checkout'])->name('orders.checkout');
    Route::post('/store', [App\Http\Controllers\PublicOrderController::class, 'store'])->name('orders.store');
    Route::get('/history', [App\Http\Controllers\PublicOrderController::class, 'history'])->name('orders.history');
    Route::get('/{id}', [App\Http\Controllers\PublicOrderController::class, 'show'])->name('orders.show');
});

require __DIR__.'/auth.php';