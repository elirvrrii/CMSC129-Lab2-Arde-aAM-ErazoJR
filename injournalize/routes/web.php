<?php

use App\Http\Controllers\JournalController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect()->route('journals.index');
});

Route::get('/journals', [JournalController::class, 'index'])->name('journals.index');
Route::resource('journals', JournalController::class)->except(['show']);

Route::resource('users', UserController::class)->except(['show']);
Route::post('/users/switch/{id}', [UserController::class, 'switch'])->name('users.switch');

Route::put('journals/restore/{id}', [JournalController::class, 'restore'])->name('journals.restore');
Route::delete('journals/hard/{id}', [JournalController::class, 'hardDelete'])->name('journals.hardDelete');
