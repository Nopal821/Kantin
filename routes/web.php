<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\OrdersController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// di routes/web.php

// Route::get('/cart', [ProductController::class, 'showCart']);
// Route::post('/checkout', [CheckoutController::class, 'checkout']);
// Route::get('/tambah_makanan', [ProductController::class, 'create'])->name('products.create');
// Route::post('/products', [ProductController::class, 'store'])->name('products.store');
// Route::get('/', [ProductController::class, 'index'])->name('index');
// Route::post('/cart/add', [ProductController::class, 'addToCart'])->name('cart.add');
// Route::post('/cart/update', [ProductController::class, 'updateCart'])->name('cart.update');
// Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
// Route::post('/cart', [ProductController::class, 'showCart'])->name('cart');
// Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
// Route::post('/purchase', [PurchaseController::class, 'purchase'])->name('purchase');
// Route::post('/update-cart', [ProductController::class, 'updateCart'])->name('update.cart');
// Route::delete('/remove-cart', [ProductController::class, 'removeCart'])->name('remove.cart');

Auth::routes();

Route::get('/profile', 'ProfileController@show')->name('profile');
Route::middleware('auth')->group(function () {
    // Tambahkan rute-rute yang membutuhkan autentikasi di sini
});

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    // Rute yang hanya bisa diakses oleh admin
    
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

Route::group(['middleware' => ['auth', 'role:pengguna']], function () {

    Route::get('/orders', [OrdersController::class, 'index'])->name('orders.index');
    Route::get('/orders/accept/{orderId}', [CheckoutController::class, 'acceptOrder'])->name('orders.accept');
    Route::post('/orders/process/{orderId}', [CheckoutController::class, 'process'])->name('orders.process');

    Route::get('/orders/{order}/receipt', 'App\Http\Controllers\OrdersController@receipt')->name('orders.receipt');

Route::get('/orders/{order}/complete', 'App\Http\Controllers\OrdersController@complete')->name('orders.complete');

});

Route::group(['middleware' => ['auth', 'role:pembeli']], function () {
    Route::get('/cart', [ProductController::class, 'showCart']);
    Route::get('/tambah_makanan', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::post('/cart/add', [ProductController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update', [ProductController::class, 'updateCart'])->name('cart.update');
    Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::post('/cart', [ProductController::class, 'showCart'])->name('cart');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::post('/purchase', [PurchaseController::class, 'purchase'])->name('purchase');
    Route::post('/update-cart', [ProductController::class, 'updateCart'])->name('update.cart');
    Route::delete('/remove-cart', [ProductController::class, 'removeCart'])->name('remove.cart');
});

