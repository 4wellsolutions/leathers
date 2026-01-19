<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/deals', [ProductController::class, 'deals'])->name('deals.index');
Route::get('/category/{slug}', [ProductController::class, 'category'])->name('category.show');
Route::get('/products/{product}/review', [ReviewController::class, 'create'])->name('reviews.create');
Route::post('/products/{product}/review', [ReviewController::class, 'store'])->name('reviews.store');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('products.show');

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
use App\Http\Controllers\ComboController;
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
Route::post('/add-combo-to-cart/{id}', [CartController::class, 'addCombo'])->name('cart.add-combo');
Route::patch('/update-cart', [CartController::class, 'update'])->name('cart.update');
Route::post('/remove-from-cart', [CartController::class, 'remove'])->name('cart.remove');

use App\Http\Controllers\WishlistController;

Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add');
Route::post('/wishlist/remove', [WishlistController::class, 'remove'])->name('wishlist.remove');
Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');


Route::get('/combos', [ComboController::class, 'index'])->name('combos.index');
Route::get('/combo/{slug}', [ComboController::class, 'show'])->name('combos.show');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/success/{order_number}', [CheckoutController::class, 'success'])->name('checkout.success');

use App\Http\Controllers\AuthController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard')->middleware('auth');

// Email Test Route
Route::get('/test-email', function () {
    $order = \App\Models\Order::latest()->first();
    if (!$order)
        return "No orders found to test with.";

    try {
        \Illuminate\Support\Facades\Mail::to($order->customer_email)
            ->send(new \App\Mail\OrderPlaced($order));
        return "Test email sent successfully to " . $order->customer_email;
    } catch (\Exception $e) {
        dd([
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString(),
            'smtp_settings' => [
                'mailer' => config('mail.default'),
                'host' => config('mail.mailers.smtp.host'),
                'port' => config('mail.mailers.smtp.port'),
                'encryption' => config('mail.mailers.smtp.encryption'),
                'username' => config('mail.mailers.smtp.username'),
            ]
        ]);
    }
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
