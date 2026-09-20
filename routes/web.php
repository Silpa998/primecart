<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthHomeController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\AddToCartController;
use App\Http\Controllers\AddCategoryController;
use App\Http\Controllers\ExploreProductsController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VariationController;
use App\Http\Controllers\ProductVariationController;

// Public Routes
Route::get('/', [AuthHomeController::class, 'index'])->name('user.home');
Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AdminAuthController::class, 'login'])->name('login');
Route::post('/register', [UserController::class, 'store'])->name('register');

// Cart & Products (Publicly accessible)
Route::post('/add-to-cart/{id}', [AddToCartController::class, 'addToCart'])->name('add.to.cart');
Route::get('/cart', [AddToCartController::class, 'cart'])->name('cart');
Route::patch('/update-cart', [AddToCartController::class, 'update'])->name('update.cart');
Route::get('/remove-from-cart/{id}', [AddToCartController::class, 'remove'])->name('remove.from.cart');
Route::get('/product/{id}', [ExploreProductsController::class, 'show'])->name('product.show');
Route::get('/explore/products', [ExploreProductsController::class, 'index'])->name('products.explore');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    
    Route::post('/logout', [AuthHomeController::class, 'logout'])->name('logout');

    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle/{productId}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::post('/wishlist/move-to-cart/{id}', [WishlistController::class, 'moveToCart'])->name('wishlist.move');
    Route::get('/wishlist/show/{id}', [WishlistController::class, 'show'])->name('wishlist.show');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::get('/checkout/single/{id}', [CheckoutController::class, 'singleProductCheckout'])->name('checkout.single');
    
    // AJAX Cart
    Route::post('/cart/add/{id}', [ExploreProductsController::class, 'addToCartAjax'])->name('cart.add.ajax');

    // Category Management
    Route::resource('categories', AddCategoryController::class)->except(['show']);

    // --- ADMIN ONLY ROUTES ---
    Route::middleware(['user_role:1'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/product', [ProductController::class, 'index'])->name('product.home');
        Route::post('/product', [ProductController::class, 'store'])->name('product.store');

        Route::resource('variations', VariationController::class);
        Route::resource('product-variations', ProductVariationController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('users', UserController::class);
        Route::resource('products', ProductController::class);
    });
});