<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\ShippingController;
use App\Http\Controllers\UserOrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\SetupController;
use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 1. GUEST / PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', [ShopController::class, 'index'])->name('shop.index');
Route::get('/product/{slug}', [ShopController::class, 'show'])->name('shop.show');
Route::get('/category/{slug}', [ShopController::class, 'category'])->name('shop.category');
Route::get('/setups', [ShopController::class, 'setups'])->name('shop.setups');


/*
|--------------------------------------------------------------------------
| 2. AUTHENTICATED USER ROUTES (Customer)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/shipping', [ShippingController::class, 'edit'])->name('shipping.edit');
    Route::post('/shipping', [ShippingController::class, 'update'])->name('shipping.update');

    // Cart System
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add/{id}', [CartController::class, 'add'])->name('add');
        Route::post('/remove/{id}', [CartController::class, 'remove'])->name('remove');
        Route::post('/setup/{setup}/add', [ShopController::class, 'addSetupToCart'])->name('setup.add');
    });

    // Checkout & Payment
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    
    Route::get('/payment/{order}', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/{order}', [PaymentController::class, 'pay'])->name('payment.pay');
    Route::get('/payment-success/{order}', function ($id) {
        $order = \App\Models\Order::findOrFail($id);
        return view('payment.success', compact('order'));
    })->name('payment.success');

    // My Orders (User)
    Route::prefix('my-orders')->name('user.orders.')->group(function () {
        Route::get('/', [UserOrderController::class, 'index'])->name('index');
        Route::get('/{order}', [UserOrderController::class, 'show'])->name('show');
        Route::post('/{order}/complete', [UserOrderController::class, 'complete'])->name('complete');
    });
});


/*
|--------------------------------------------------------------------------
| 3. ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'isAdmin'])
    ->prefix('admin') // URL jadi: /admin/...
    ->name('admin.')   // Nama route jadi: admin.index
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('setups', SetupController::class);
        
        Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update']);
});

require __DIR__.'/auth.php';