<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CnamController;
use App\Http\Controllers\AuthCnamController;
use App\Http\Controllers\LaboratorController;
use App\Http\Controllers\ProceduraController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
// Login
Route::get('/', [AuthCnamController::class, 'showLogin'])->name('home');
Route::get('login', [AuthCnamController::class, 'showLogin'])->name('auth.login');
Route::post('login', [AuthCnamController::class, 'login'])->name('auth.login.post');

// Logout
Route::get('logout', [AuthCnamController::class, 'logout'])->name('auth.logout');

Route::middleware(['auth.cnam'])->group(function () {
    Route::resource('cnam', CnamController::class);
    // Route::get('/laborator', [LaboratorController::class, 'index'])->name('laborator.index');
    // Route::post('/laborator/store', [LaboratorController::class, 'store'])->name('laborator.store');
    Route::get('/laborator', [LaboratorController::class, 'create'])->name('laborator.create');
    Route::post('/laborator', [LaboratorController::class, 'store'])->name('laborator.store');
    Route::delete('/laborator/fisiere/{id}', [LaboratorController::class, 'destroyFisier'])->name('laborator.fisiere.destroy');
    Route::get('/laborator/show', [LaboratorController::class, 'showAll'])->name('laborator.show');


    Route::get('/proceduri', [ProceduraController::class, 'index'])->name('proceduri.index');
    Route::get('/proceduri/create', [ProceduraController::class, 'create'])->name('proceduri.create');
    Route::post('/proceduri', [ProceduraController::class, 'store'])->name('proceduri.store');
});
