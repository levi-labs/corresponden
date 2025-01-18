<?php

use App\Http\Controllers\ArchiveIncomingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard.index');

Route::controller(App\Http\Controllers\LetterTypeController::class)
    ->prefix('letter-type')
    ->middleware(['auth', 'roles:admin'])
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
    ->middleware(['auth', 'roles:admin'])
    ->group(function () {
        Route::get('/', 'index')->name('user.index');
        Route::get('/create', 'create')->name('user.create');
        Route::post('/', 'store')->name('user.store');
        Route::get('/{user}', 'show')->name('user.show');
        Route::get('/{user}/edit', 'edit')->name('user.edit');
        Route::put('/{user}', 'update')->name('user.update');
        Route::delete('/{user}', 'destroy')->name('user.destroy');
    });
Route::controller(App\Http\Controllers\SentController::class)
    ->prefix('outgoing-letter')
    ->middleware(['auth', 'roles:admin,staff,student,lecturer'])
    ->group(function () {
        Route::get('/', 'index')->name('outgoing-letter.index');
        Route::get('/create', 'create')->name('outgoing-letter.create');
        Route::post('/', 'store')->name('outgoing-letter.store');
        Route::get('/{outgoingLetter}', 'show')->name('outgoing-letter.show');
        Route::get('/{outgoingLetter}/edit', 'edit')->name('outgoing-letter.edit');
        Route::put('/{outgoingLetter}', 'update')->name('outgoing-letter.update');
        Route::delete('/{outgoingLetter}', 'destroy')->name('outgoing-letter.destroy');
    });
Route::controller(App\Http\Controllers\InboxController::class)
    ->prefix('incoming-letter')
    ->middleware(['auth', 'roles:admin,staff,student,lecturer'])
    ->group(function () {
        Route::get('/', 'index')->name('incoming-letter.index');
        Route::get('/create', 'create')->name('incoming-letter.create');
        Route::post('/approve', 'approve')->name('incoming-letter.approve');
        Route::get('/{incomingLetter}', 'show')->name('incoming-letter.show');
        Route::get('/{incomingLetter}/edit', 'edit')->name('incoming-letter.edit');
        Route::put('/{incomingLetter}', 'update')->name('incoming-letter.update');
        Route::delete('/{incomingLetter}', 'destroy')->name('incoming-letter.destroy');
        Route::get('/download/{idLetter}/reply', 'downloadReply')->name('reply-letter.download');
        Route::get('/download-file-inbox/{id}', 'downloadFileInbox')->name('incoming-letter.download');
        Route::get('/reply-destroy/{idReply}', 'destroyReply')->name('reply-letter.destroy');
        Route::get('/reply-preview/{idReply}', 'previewReply')->name('reply-letter.preview');
    });
Route::controller(App\Http\Controllers\ArchiveIncomingController::class)
    ->prefix('archive-incoming-letter')
    ->middleware(['auth', 'roles:admin'])
    ->group(function () {
        Route::get('/', 'index')->name('archive-incoming-letter.index');
        Route::get('/create', 'create')->name('archive-incoming-letter.create');
        Route::post('/', 'store')->name('archive-incoming-letter.store');
        Route::get('/{archiveIncomingLetter}', 'show')->name('archive-incoming-letter.show');
        Route::get('/{archiveIncomingLetter}/edit', 'edit')->name('archive-incoming-letter.edit');
        Route::put('/{archiveIncomingLetter}', 'update')->name('archive-incoming-letter.update');
        Route::delete('/{archiveIncomingLetter}', 'destroy')->name('archive-incoming-letter.destroy');
    });
Route::controller(ProfileController::class)
    ->prefix('profile')
    ->middleware(['auth', 'roles:admin,staff,student,lecturer'])
    ->group(function () {
        Route::get('/', 'showProfile')->name('profile.index');
        Route::get('/edit', 'editProfile')->name('profile.edit');
        Route::put('/update-profile', 'update')->name('profile.update');
    });
