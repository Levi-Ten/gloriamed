<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CnamController;
use App\Http\Controllers\AuthCnamController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
// Login
Route::get('login', [AuthCnamController::class, 'showLogin'])->name('auth.login');
Route::post('login', [AuthCnamController::class, 'login'])->name('auth.login.post');

// Logout
Route::get('logout', [AuthCnamController::class, 'logout'])->name('auth.logout');

Route::middleware(['auth.cnam'])->group(function () {
    Route::resource('cnam', CnamController::class);
});