<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserProfileController;

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
    
    // إتمام الطلب (Checkout)
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/store', [OrderController::class, 'store'])->name('order.store');
    Route::get('/order-success', [OrderController::class, 'success'])->name('order.success');

    // حسابي الشخصي (البروفايل الجديد اللي عملناه)
    Route::get('/my-account', [UserProfileController::class, 'index'])->name('user.profile');
    Route::post('/my-account/update', [UserProfileController::class, 'update'])->name('profile.update');

    // مسارات Breeze الأصلية (لو حبيت ترجع لها)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update_breeze');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // صفحة الـ Dashboard الأساسية
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// ملف روابط المصادقة (Login, Register, etc)
require __DIR__.'/auth.php';