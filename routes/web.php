<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DiscountController as AdminDiscountController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ProductPhotoController as AdminProductPhotoController;
use App\Http\Controllers\Admin\PurchaseOrderController as AdminPurchaseOrderController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\SupplierController as AdminSupplierController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/test-email', function () {
    try {
        \Mail::raw('This is a test email from The Pop Stop application.', function ($message) {
            $message->to('test@example.com')
                    ->subject('Mailtrap Test Email')
                    ->from('noreply@thepopstop.com', 'The Pop Stop');
        });
        
        return 'Test email sent successfully! Check your Mailtrap inbox.';
    } catch (\Exception $e) {
        return 'Error sending email: ' . $e->getMessage();
    }
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register')->middleware('guest');
Route::post('/register', [RegisterController::class, 'register'])->middleware('guest');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (\Illuminate\Foundation\Auth\EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (\Illuminate\Http\Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show')->where('product', '[0-9]+');

// Custom image server to bypass broken symlinks
Route::get('/img-data/{path}', function ($path) {
    $fullPath = storage_path('app/public/' . $path);
    if (!file_exists($fullPath)) {
        // Fallback to a placeholder if file not found
        return response()->redirectTo('https://ui-avatars.com/api/?name=NotFound&background=f00&color=fff');
    }
    
    $file = file_get_contents($fullPath);
    $type = mime_content_type($fullPath);
    
    return response($file)->header('Content-Type', $type);
})->where('path', '.*')->name('image.serve');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::put('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}/receipt', [OrderController::class, 'receipt'])->name('orders.receipt');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/products/import', fn () => view('admin.products.import'))->name('products.import-form');
    Route::post('/products/import', [AdminProductController::class, 'import'])->name('products.import');
    Route::resource('products', AdminProductController::class);
    Route::post('/products/{id}/restore', [AdminProductController::class, 'restore'])->name('products.restore');

    Route::get('/products/{product}/photos', [AdminProductPhotoController::class, 'index'])->name('products.photos.index');
    Route::post('/products/{product}/photos', [AdminProductPhotoController::class, 'store'])->name('products.photos.store');
    Route::delete('/products/{product}/photos/{photo}', [AdminProductPhotoController::class, 'destroy'])->name('products.photos.destroy');
    Route::post('/products/{product}/photos/{photo}/primary', [AdminProductPhotoController::class, 'setPrimary'])->name('products.photos.primary');
    Route::post('/products/{product}/photos/clear-primary', [AdminProductPhotoController::class, 'clearPrimary'])->name('products.photos.clear-primary');

    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}/status', [AdminOrderController::class, 'update'])->name('orders.status');

    Route::resource('users', AdminUserController::class);
    Route::post('/users/{user}/toggle-active', [AdminUserController::class, 'toggleActive'])->name('users.toggle-active');

    Route::resource('suppliers', AdminSupplierController::class);
    Route::resource('purchase-orders', AdminPurchaseOrderController::class)->parameters(['purchase-orders' => 'purchaseOrder']);
    Route::get('/purchase-orders/{purchaseOrder}', [AdminPurchaseOrderController::class, 'show'])->name('purchase-orders.show');
    Route::put('/purchase-orders/{purchaseOrder}/status', [AdminPurchaseOrderController::class, 'updateStatus'])->name('purchase-orders.update-status');

    Route::resource('discounts', AdminDiscountController::class);

    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
    Route::delete('/reviews/{review}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');
});
