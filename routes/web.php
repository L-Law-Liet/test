<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\TestController::class, 'test'])->name('test');
Route::post('/', [\App\Http\Controllers\TestController::class, 'store'])->name('store');
