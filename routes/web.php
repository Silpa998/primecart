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


use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;

// Route::get('/', function () {`
//     return view('welcome');
// });

//without auth middleware, using session 
Route::get('/', [AuthHomeController::class, 'index'])->name('user.home');
Route::post('/add-to-cart/{id}', [AddToCartController::class, 'addToCart'])->name('add.to.cart');
Route::get('/cart', [AddToCartController::class, 'cart'])->name('cart');
Route::patch('/update-cart', [AddToCartController::class, 'update'])->name('update.cart');
Route::get('/remove-from-cart/{id}', [AddToCartController::class, 'remove'])->name('remove.from.cart');    
Route::post('/logout', [AuthHomeController::class, 'logout'])->name('logout');

Route::resource('products', ProductController::class);

//wishlist
    Route::post('/wishlist/toggle/{productId}', [WishlistController::class, 'toggle'])
        ->middleware('auth')->name('wishlist.toggle');
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index'); 
    
    Route::post('/wishlist/move-to-cart/{id}', [WishlistController::class, 'moveToCart'])
        ->name('wishlist.move');
    Route::get('/wishlist/show/{id}', [WishlistController::class, 'show'])->name('wishlist.show');
     


// Common Login Route (Admin and User)
Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AdminAuthController::class, 'login'])->name('login');

// User Registration Route
Route::post('/register', [UserController::class, 'store'])->name('register');


// --- ADMIN ROUTES ---
Route::prefix('admin')->group(function () {
    
    // Admin Routes (Admin-role:1)
    Route::middleware(['auth', 'user_role:1'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

        Route::get('/product', [ProductController::class, 'index'])->name('product.home');
        Route::post('/product', [ProductController::class, 'store'])->name('product.store');
        // Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');

        Route::resource('roles', RoleController::class);
        Route::resource('users', UserController::class);
        // Route::resource('products', ProductController::class);
    });
});

// --- USER ROUTES ---(User-role:0)
Route::middleware(['auth'])->group(function () {
    
    // Route::get('/home', [AuthHomeController::class, 'index'])->name('user.home');
    
    //category
    Route::get('/categories', [AddCategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [AddCategoryController::class, 'addCategories'])->name('categories.create');
    Route::post('/categories', [AddCategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [AddCategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [AddCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [AddCategoryController::class, 'destroy'])->name('categories.destroy');

    //wishlist
    // Route::post('/wishlist/toggle/{productId}', [WishlistController::class, 'toggle'])
    //     ->middleware('auth')->name('wishlist.toggle');
    // Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index'); 
    
    // Route::post('/wishlist/move-to-cart/{id}', [WishlistController::class, 'moveToCart'])
    //     ->name('wishlist.move');
    // Route::get('/wishlist/show/{id}', [WishlistController::class, 'show'])->name('wishlist.show');
     
    
    //cart
    // Route::get('/cart', [AddToCartController::class, 'cart'])->name('cart');
    // Route::get('/add-to-cart/{id}', [AddToCartController::class, 'addToCart'])->name('add.to.cart');
    // Route::patch('/update-cart', [AddToCartController::class, 'update'])->name('update.cart');
    // Route::get('/remove-from-cart/{id}', [AddToCartController::class, 'remove'])->name('remove.from.cart');    Route::post('/logout', [AuthHomeController::class, 'logout'])->name('logout');

    //in cart
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::get('/checkout/single/{id}', [CheckoutController::class, 'singleProductCheckout'])->name('checkout.single');

    //explore products
    Route::get('/explore/products', [ExploreProductsController::class, 'index'])->name('products.explore');});
    Route::post('/cart/add/{id}', [ExploreProductsController::class, 'addToCartAjax'])->name('cart.add.ajax'); //explore more on this ajax method for adding to cart without page reload  
    Route::get('/product/{id}', [ExploreProductsController::class, 'show'])->name('product.show');


