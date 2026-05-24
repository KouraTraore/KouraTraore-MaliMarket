<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\CategoryController as AdminCategory;
use App\Http\Controllers\Admin\ProductController as AdminProduct;
use App\Http\Controllers\Admin\VendorController as AdminVendor;
use App\Http\Controllers\Admin\OrderController as AdminOrder;
use App\Http\Controllers\Vendor\DashboardController as VendorDashboard;
use App\Http\Controllers\Vendor\ProductController as VendorProduct;
use App\Http\Controllers\Shop\HomeController;
use App\Http\Controllers\Shop\CartController;
use App\Http\Controllers\Shop\OrderController as ShopOrder;

// ========== BOUTIQUE (PUBLIC) ==========
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/produit/{slug}', [HomeController::class, 'show'])->name('product.show');
Route::get('/categorie/{slug}', [HomeController::class, 'category'])->name('category.show');
Route::get('/recherche', [HomeController::class, 'search'])->name('search');

// ========== PANIER ==========
Route::get('/panier', [CartController::class, 'index'])->name('cart.index');
Route::post('/panier/ajouter', [CartController::class, 'add'])->name('cart.add');
Route::put('/panier/modifier/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/panier/supprimer/{id}', [CartController::class, 'remove'])->name('cart.remove');

// ========== AUTHENTIFICATION ==========
Route::get('/connexion', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/connexion', [LoginController::class, 'login']);
Route::post('/deconnexion', [LoginController::class, 'logout'])->name('logout');
Route::get('/inscription', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/inscription', [RegisterController::class, 'register']);

// ========== COMMANDES (CLIENT) ==========
Route::middleware(['auth'])->group(function () {
    Route::get('/commander', [ShopOrder::class, 'checkout'])->name('checkout');
    Route::post('/commander', [ShopOrder::class, 'store'])->name('order.store');
    Route::get('/mes-commandes', [ShopOrder::class, 'index'])->name('orders.index');
    Route::get('/mes-commandes/{id}', [ShopOrder::class, 'show'])->name('orders.show');
});

// ========== ADMIN ==========
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // Catégories
    Route::resource('categories', AdminCategory::class);

    // Produits
    Route::resource('products', AdminProduct::class);

    // Vendeurs
    Route::get('/vendeurs', [AdminVendor::class, 'index'])->name('vendors.index');
    Route::put('/vendeurs/{id}/approuver', [AdminVendor::class, 'approve'])->name('vendors.approve');
    Route::put('/vendeurs/{id}/suspendre', [AdminVendor::class, 'suspend'])->name('vendors.suspend');

    // Commandes
    Route::get('/commandes', [AdminOrder::class, 'index'])->name('orders.index');
    Route::get('/commandes/{id}', [AdminOrder::class, 'show'])->name('orders.show');
    Route::put('/commandes/{id}/statut', [AdminOrder::class, 'updateStatut'])->name('orders.statut');
});

// ========== VENDEUR ==========
Route::prefix('vendeur')->middleware(['auth', 'vendor'])->name('vendor.')->group(function () {
    Route::get('/dashboard', [VendorDashboard::class, 'index'])->name('dashboard');
    Route::resource('products', VendorProduct::class);
});
// Avis clients
Route::post('/produit/{id}/avis', [App\Http\Controllers\Shop\ReviewController::class, 'store'])->name('review.store');
Route::delete('/avis/{id}', [App\Http\Controllers\Shop\ReviewController::class, 'destroy'])->name('review.destroy');