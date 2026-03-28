<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\JournalController;

Route::get('/journals', [JournalController::class, 'index'])->name('journals.index');
Route::get('/', function() { return redirect()->route('journals.index'); });

Route::resource('users', UserController::class)->only(['index','create','store']);
Route::resource('journals', JournalController::class)->except(['show']);

Route::resource('users', UserController::class)->only(['index','create','store','destroy']);
Route::get('/users/switch/{id}', [UserController::class, 'switch'])->name('users.switch');

Route::put('journals/restore/{id}', [JournalController::class,'restore'])->name('journals.restore');
Route::delete('journals/hard/{id}', [JournalController::class,'hardDelete'])->name('journals.hardDelete');
