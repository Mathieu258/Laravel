<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EntrepreneurController;
use App\Http\Controllers\ShowcaseController;
use App\Http\Controllers\CartController;

Route::get('/', function () { return view('pages.dashboad'); });

// Auth Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('approve/{user}', [AdminController::class, 'approve'])->name('approve');
    Route::delete('reject/{user}', [AdminController::class, 'reject'])->name('reject');
});

// Entrepreneur Routes
Route::middleware(['auth', 'role:contractor_approved'])->prefix('entrepreneur')->name('entrepreneur.')->group(function () {
    Route::get('dashboard', [EntrepreneurController::class, 'dashboard'])->name('dashboard');
    Route::get('products', [EntrepreneurController::class, 'products'])->name('products');
    Route::get('products/create', [EntrepreneurController::class, 'createProduct'])->name('products.create');
    Route::post('products', [EntrepreneurController::class, 'storeProduct'])->name('products.store');
    Route::get('products/{product}/edit', [EntrepreneurController::class, 'editProduct'])->name('products.edit');
    Route::put('products/{product}', [EntrepreneurController::class, 'updateProduct'])->name('products.update');
    Route::delete('products/{product}', [EntrepreneurController::class, 'deleteProduct'])->name('products.delete');
});

// Public Showcase Routes
Route::get('exhibitors', [ShowcaseController::class, 'exhibitors'])->name('exhibitors');
Route::get('stand/{stand}', [ShowcaseController::class, 'stand'])->name('stand');

// Cart Routes
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'cart'])->name('index');
    Route::post('add/{product}', [CartController::class, 'add'])->name('add');
    Route::delete('remove/{product}', [CartController::class, 'remove'])->name('remove');
    Route::post('place-order', [CartController::class, 'placeOrder'])->name('placeOrder');
});