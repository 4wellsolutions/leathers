<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/sales', [ProductController::class, 'sales'])->name('sales.index');
Route::get('/category/{slug}', [ProductController::class, 'category'])->name('category.show');
Route::get('/products/{product}/review', [ReviewController::class, 'create'])->name('reviews.create');
Route::post('/products/{product}/review', [ReviewController::class, 'store'])->name('reviews.store');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/orders/{order_number}/review/{product}/{variant?}', [ReviewController::class, 'createFromOrder'])->name('reviews.write-for-order');
Route::get('/orders/{order_number}/reviews', [ReviewController::class, 'createForOrder'])->name('reviews.create-for-order');

// Blog Routes
Route::get('/blog', [App\Http\Controllers\FrontendBlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [App\Http\Controllers\FrontendBlogController::class, 'show'])->name('blog.show');

// Contact Us
Route::get('/contact-us', [App\Http\Controllers\ContactController::class, 'index'])->name('contact');
Route::post('/contact-us', [App\Http\Controllers\ContactController::class, 'send'])->name('contact.send');

// Pages
Route::get('/page/{slug}', [App\Http\Controllers\PageController::class, 'show'])->name('pages.show');


use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DealController;
Route::middleware('guest')->group(function () {
    Route::get('forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendOtp'])->name('password.email');
    Route::get('verify-otp', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showVerifyForm'])->name('password.verify');
    Route::post('verify-otp', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'verifyOtp'])->name('password.verify.post');
    Route::get('reset-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('reset-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'resetPassword'])->name('password.update');
});
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/add-to-cart/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/add-deal-to-cart/{id}', [CartController::class, 'addDeal'])->name('cart.add-deal');
Route::patch('/update-cart', [CartController::class, 'update'])->name('cart.update');
Route::post('/remove-from-cart', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.apply-coupon');
Route::post('/remove-coupon', [CartController::class, 'removeCoupon'])->name('cart.remove-coupon');

use App\Http\Controllers\WishlistController;

Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add');
Route::post('/wishlist/remove', [WishlistController::class, 'remove'])->name('wishlist.remove');
Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');


Route::get('/deals', [DealController::class, 'index'])->name('deals.index');
Route::get('/deals/{slug}', [DealController::class, 'show'])->name('deals.show');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/success/{order_number}', [CheckoutController::class, 'success'])->name('checkout.success');

use App\Http\Controllers\UserOrderController;
use App\Http\Controllers\AuthController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/my-orders', [UserOrderController::class, 'index'])->name('my-orders.index');
    Route::get('/my-orders/{order_number}', [UserOrderController::class, 'show'])->name('my-orders.show');
    Route::get('/my-orders/{order_number}/invoice', [UserOrderController::class, 'invoice'])->name('my-orders.invoice');

    // Profile Routes
    Route::get('/my-profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.edit');
    Route::post('/my-profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});

// Email Test Route
// Email Test Routes
Route::prefix('test-emails')->group(function () {
    Route::get('/placed', function () {
        $order = \App\Models\Order::latest()->first();
        if (!$order)
            return "No orders found.";
        \Illuminate\Support\Facades\Mail::to($order->customer_email)->send(new \App\Mail\OrderPlaced($order));
        return "Placed email sent.";
    });

    Route::get('/confirmed', function () {
        $order = \App\Models\Order::latest()->first();
        if (!$order)
            return "No orders found.";
        \Illuminate\Support\Facades\Mail::to($order->customer_email)->send(new \App\Mail\OrderConfirmed($order));
        return "Confirmed email sent.";
    });

    Route::get('/shipped', function () {
        $order = \App\Models\Order::latest()->first();
        if (!$order)
            return "No orders found.";
        \Illuminate\Support\Facades\Mail::to($order->customer_email)->send(new \App\Mail\OrderShipped($order));
        return "Shipped email sent.";
    });

    Route::get('/delivered', function () {
        $order = \App\Models\Order::latest()->first();
        if (!$order)
            return "No orders found.";
        \Illuminate\Support\Facades\Mail::to($order->customer_email)->send(new \App\Mail\OrderDelivered($order));
        return "Delivered email sent.";
    });
});

// Admin Routes
require __DIR__ . '/admin.php';


// Public Cache Clear Route (Remove this after testing for security)
Route::get('/clear-cache', function () {
    \Artisan::call('cache:clear');
    \Artisan::call('config:clear');
    \Artisan::call('route:clear');
    \Artisan::call('view:clear');

    return response()->json([
        'success' => true,
        'message' => 'All caches cleared successfully!',
        'cleared' => [
            'Application Cache',
            'Configuration Cache',
            'Route Cache',
            'View Cache'
        ]
    ]);
});

