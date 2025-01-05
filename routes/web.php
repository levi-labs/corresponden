<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard.index');

Route::controller(App\Http\Controllers\LetterTypeController::class)
    ->prefix('letter-type')
    ->group(function () {
        Route::get('/', 'index')->name('letter-type.index');
        Route::get('/create', 'create')->name('letter-type.create');
        Route::post('/', 'store')->name('letter-type.store');
        Route::get('/{letterType}', 'show')->name('letter-type.show');
        Route::get('/{letterType}/edit', 'edit')->name('letter-type.edit');
        Route::put('/{letterType}', 'update')->name('letter-type.update');
        Route::delete('/{letterType}', 'destroy')->name('letter-type.destroy');
    });
Route::controller(App\Http\Controllers\UserController::class)
    ->prefix('user')
    ->group(function () {
        Route::get('/', 'index')->name('user.index');
        Route::get('/create', 'create')->name('user.create');
        Route::post('/', 'store')->name('user.store');
        Route::get('/{user}', 'show')->name('user.show');
        Route::get('/{user}/edit', 'edit')->name('user.edit');
        Route::put('/{user}', 'update')->name('user.update');
        Route::delete('/{user}', 'destroy')->name('user.destroy');
    });
