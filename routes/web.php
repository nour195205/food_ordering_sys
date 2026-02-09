<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController; // تأكد إن السطر ده موجود فوق خالص
use App\Http\Controllers\CartController;


Route::get('/', function () {
    return view('welcome');
});

//-------------------Menu------------------//

Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');

Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

Route::post('/cart/toggle-combo/{key}', [CartController::class, 'toggleCombo'])->name('cart.toggleCombo');


//-------------------Dashboard------------------//

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
