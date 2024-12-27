<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

Route::get('/', [TestController::class, 'index'])->name('test');
Route::post('/add-item', [TestController::class, 'addItem'])->name('add-item');
Route::post('/add-bundle', [TestController::class, 'addBundle'])->name('add-bundle');
Route::post('/update-item-quantity', [TestController::class, 'updateItemQuantity'])->name('update-item-quantity');
Route::post('/remove-item', [TestController::class, 'removeItem'])->name('remove-item');


Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
