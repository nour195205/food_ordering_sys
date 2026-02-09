<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\DashboardController;

use Illuminate\Support\Facades\Route;

// الصفحة الرئيسية (Welcome)
Route::get('/', function () {
    return view('welcome');
});

// مسارات المنيو (متاحة للجميع)
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');

// مسارات سلة المشتريات (Session based)
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/toggle-combo/{key}', [CartController::class, 'toggleCombo'])->name('cart.toggleCombo');
    Route::post('/remove/{key}', [CartController::class, 'remove'])->name('cart.remove');
});

// المسارات التي تتطلب تسجيل دخول (Middleware Auth)
Route::middleware('auth')->group(function () {
    Route::post('/admin/orders/{id}/update-status', [DashboardController::class, 'updateStatus'])->name('admin.orders.updateStatus');
Route::get('/admin/orders/{id}', [DashboardController::class, 'showOrder'])->name('admin.orders.show');
Route::get('/admin/orders/{id}/edit', [DashboardController::class, 'editOrder'])->name('admin.orders.edit');
Route::put('/admin/orders/{id}/update', [DashboardController::class, 'updateOrder'])->name('admin.orders.update');

    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // إتمام الطلب (Checkout)
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/store', [OrderController::class, 'store'])->name('order.store');
    Route::get('/order-success', [OrderController::class, 'success'])->name('order.success');

    // توجيه رابط حسابي القديم للرابط الجديد (Breeze)
    Route::redirect('/my-account', '/profile');
    Route::redirect('/my-account/update', '/profile');

    // مسارات Breeze الأصلية (لو حبيت ترجع لها)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // صفحة الـ Dashboard الأساسية
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// ملف روابط المصادقة (Login, Register, etc)
require __DIR__.'/auth.php';