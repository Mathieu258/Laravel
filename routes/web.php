<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StandController;

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

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', function () {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Accès refusé.');
        }
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/test-role', function () {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Accès refusé.');
        }
        return 'OK';
    });

    Route::resource('stands', StandController::class);
});

require __DIR__.'/auth.php';