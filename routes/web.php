<?php

use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;



Route::get('/subscribe', function () {
    return view('subscribe');
})->middleware('auth');

Route::post('/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscribe')->middleware('auth');
