<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\CareerController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\JobOfferController;
use App\Http\Controllers\Admin\ApplicationController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\System\SystemStatusController;

// ============================================================
// SYSTEM — Gestion de la disponibilité (accès direct uniquement)
// ============================================================
Route::prefix('system')->name('system.')->group(function () {
    Route::get('/status',        [SystemStatusController::class, 'index'])->name('status');
    Route::post('/status/update',[SystemStatusController::class, 'update'])->name('status.update');
});

// Prévisualisation des pages d'erreur (accès direct, pas de middleware)
Route::prefix('data-preview')->group(function () {
    Route::get('/service-unavailable', fn() => view('data.service-unavailable'));
    Route::get('/account-suspended',   fn() => view('data.account-suspended'));
    Route::get('/security-lock',       fn() => view('data.security-lock'));
    Route::get('/database-error',      fn() => view('data.database-error'));
    Route::get('/maintenance',         fn() => view('data.maintenance'));
});

// ============================================================
// FRONTEND — Routes publiques
// ============================================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/a-propos', [HomeController::class, 'about'])->name('about');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// Produits publics
Route::get('/produits', [ProductController::class, 'index'])->name('products.index');
Route::get('/produits/{product}', [ProductController::class, 'show'])->name('products.show');

// Carrières publiques
Route::get('/carrieres', [CareerController::class, 'index'])->name('careers.index');
Route::get('/carrieres/{jobOffer}', [CareerController::class, 'show'])->name('careers.show');
Route::post('/carrieres/{jobOffer}/postuler', [CareerController::class, 'apply'])->name('careers.apply');

// ──────────────────────────────────────────────────────────
// PANIER (session-based)
// ──────────────────────────────────────────────────────────
Route::get('/panier', [CartController::class, 'index'])->name('cart.index');
Route::post('/panier/ajouter', [CartController::class, 'add'])->name('cart.add');
Route::patch('/panier/{cartKey}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/panier/{cartKey}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/panier', [CartController::class, 'clear'])->name('cart.clear');

// ──────────────────────────────────────────────────────────
// COMMANDES (checkout & confirmation)
// ──────────────────────────────────────────────────────────
Route::get('/commander', [OrderController::class, 'checkout'])->name('orders.checkout');
Route::post('/commander', [OrderController::class, 'store'])->name('orders.store');
Route::get('/commander/confirmation/{order}', [OrderController::class, 'success'])->name('orders.success');


// ============================================================
// ADMIN — Authentification (pas de middleware)
// ============================================================
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ========================================================
    // ADMIN — Zone protégée (middleware admin)
    // ========================================================
    Route::middleware('admin')->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Produits (CRUD complet)
        Route::resource('products', AdminProductController::class)->except(['show'])
             ->names([
                 'index'   => 'products.index',
                 'create'  => 'products.create',
                 'store'   => 'products.store',
                 'edit'    => 'products.edit',
                 'update'  => 'products.update',
                 'destroy' => 'products.destroy',
             ]);

        // Offres d'emploi (CRUD complet)
        Route::resource('jobs', JobOfferController::class)->except(['show'])
             ->names([
                 'index'   => 'jobs.index',
                 'create'  => 'jobs.create',
                 'store'   => 'jobs.store',
                 'edit'    => 'jobs.edit',
                 'update'  => 'jobs.update',
                 'destroy' => 'jobs.destroy',
             ]);

        // Candidatures
        Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
        Route::get('/applications/{application}', [ApplicationController::class, 'show'])->name('applications.show');
        Route::patch('/applications/{application}/status', [ApplicationController::class, 'updateStatus'])->name('applications.status');
        Route::delete('/applications/{application}', [ApplicationController::class, 'destroy'])->name('applications.destroy');
        Route::get('/applications/{application}/cv', [ApplicationController::class, 'downloadCv'])->name('applications.cv');

        // Sliders (CRUD complet)
        Route::resource('sliders', SliderController::class)->except(['show'])
             ->names([
                 'index'   => 'sliders.index',
                 'create'  => 'sliders.create',
                 'store'   => 'sliders.store',
                 'edit'    => 'sliders.edit',
                 'update'  => 'sliders.update',
                 'destroy' => 'sliders.destroy',
             ]);

        // Commandes admin
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
        Route::patch('/orders/{order}/notes', [AdminOrderController::class, 'updateNotes'])->name('orders.notes');
        Route::delete('/orders/{order}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');
    });
});
