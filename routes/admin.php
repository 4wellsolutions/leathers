<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here are all the admin panel routes. These routes are protected by
| 'auth' and 'admin' middleware and prefixed with '/admin'.
|
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    // Products
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    Route::post('products/{product}/toggle-status', [\App\Http\Controllers\Admin\ProductController::class, 'toggleStatus'])->name('products.toggle-status');

    // Categories
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);

    // Sales (formerly Deals)
    Route::resource('sales', \App\Http\Controllers\Admin\SaleController::class);

    // Deals (formerly Combos)
    Route::get('deals/search-products', [\App\Http\Controllers\Admin\DealController::class, 'searchProducts'])->name('deals.search-products');
    Route::resource('deals', \App\Http\Controllers\Admin\DealController::class);

    // Blogs
    Route::resource('blogs', \App\Http\Controllers\Admin\BlogController::class);
    Route::resource('blog-categories', \App\Http\Controllers\Admin\BlogCategoryController::class);

    // Media
    Route::resource('media', \App\Http\Controllers\Admin\MediaController::class);

    // Pages
    Route::resource('pages', \App\Http\Controllers\Admin\PageController::class);

    // Redirects
    Route::resource('redirects', \App\Http\Controllers\Admin\RedirectController::class);

    Route::resource('deals', \App\Http\Controllers\Admin\DealController::class);

    // Users
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);

    // Orders
    Route::post('orders/{order}/resend-email', [\App\Http\Controllers\Admin\OrderController::class, 'resendEmail'])->name('orders.resend-email');
    Route::patch('orders/{order}/status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class);

    // Email Templates
    Route::resource('email-templates', \App\Http\Controllers\Admin\EmailTemplateController::class);

    // Shipping Rules
    Route::resource('shipping-rules', \App\Http\Controllers\Admin\ShippingRuleController::class);

    // Sitemap
    Route::get('/sitemap', [\App\Http\Controllers\Admin\SitemapController::class, 'index'])->name('sitemap.index');
    Route::post('/sitemap/generate', [\App\Http\Controllers\Admin\SitemapController::class, 'generate'])->name('sitemap.generate');
    Route::get('/sitemap/download', [\App\Http\Controllers\Admin\SitemapController::class, 'download'])->name('sitemap.download');

    // Coupons
    Route::resource('coupons', \App\Http\Controllers\Admin\CouponController::class);

    // Cache Management
    Route::get('/cache', [\App\Http\Controllers\Admin\CacheController::class, 'index'])->name('cache.index');
    Route::post('/cache/clear-all', [\App\Http\Controllers\Admin\CacheController::class, 'clearAll'])->name('cache.clear-all');
    Route::post('/cache/clear/{type}', [\App\Http\Controllers\Admin\CacheController::class, 'clearSpecific'])->name('cache.clear');
    Route::post('/cache/rebuild', [\App\Http\Controllers\Admin\CacheController::class, 'rebuild'])->name('cache.rebuild');

    // Reports
    Route::get('/reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/inventory', [\App\Http\Controllers\Admin\ReportController::class, 'inventory'])->name('reports.inventory');
    Route::get('/reports/inventory/pdf', [\App\Http\Controllers\Admin\ReportController::class, 'inventoryPdf'])->name('reports.inventory.pdf');

    // Settings
    Route::get('/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('settings.update');
});
