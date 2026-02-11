<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\StaffManagementController;


use Illuminate\Support\Facades\Route;

// الصفحة الرئيسية (Welcome)
Route::get('/', function () {
    return view('welcome');
});

// مسارات المنيو (متاحة للجميع)
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::get('/about-us', [App\Http\Controllers\AboutController::class, 'index'])->name('about.index');

// مسارات سلة المشتريات (Session based)
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/update/{key}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/toggle-combo/{key}', [CartController::class, 'toggleCombo'])->name('cart.toggleCombo');
    Route::post('/remove/{key}', [CartController::class, 'remove'])->name('cart.remove');
});


// routes/web.php

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // إدارة الصلاحيات للموظفين (للأدمن فقط) - أو ممكن نعملها permission اسمها manage_staff
    Route::resource('staff', StaffManagementController::class)->middleware('permission:manage_staff'); // لازم تضيف manage_staff في الـ availablePermissions

    // إعدادات الموقع
    Route::get('/settings', [App\Http\Controllers\SettingsController::class, 'index'])->name('settings.index')->middleware('permission:manage_settings');
    Route::post('/settings', [App\Http\Controllers\SettingsController::class, 'update'])->name('settings.update')->middleware('permission:manage_settings');
});

// المسارات التي تتطلب تسجيل دخول (Middleware Auth)
Route::middleware('auth')->group(function () {

    Route::resource('admin/categories', AdminCategoryController::class)->names([
        'index' => 'admin.categories.index',
        'store' => 'admin.categories.store',
        'update' => 'admin.categories.update',
        'destroy' => 'admin.categories.destroy',
    ])->middleware('permission:manage_categories');

    Route::resource('admin/products', AdminProductController::class)->names([
        'index' => 'admin.products.index',
        'create' => 'admin.products.create',
        'store' => 'admin.products.store',
        'edit' => 'admin.products.edit',
        'update' => 'admin.products.update',
        'destroy' => 'admin.products.destroy',
    ])->middleware('permission:manage_products');

    // إدارة الطلبات (Admin Orders)
    Route::controller(App\Http\Controllers\AdminOrderController::class)->prefix('admin/orders')->name('admin.orders.')->middleware('permission:manage_orders')->group(function () {
        Route::get('/', 'index')->name('index'); // صفحة كل الطلبات
        Route::get('/{id}', 'show')->name('show'); // تفاصيل الطلب
        Route::post('/{id}/update-status', 'updateStatus')->name('updateStatus'); // تحديث الحالة
    });

    Route::get('/admin/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard')
        ->middleware('permission:view_reports'); // أو view_dashboard
    
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