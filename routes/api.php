<?php

use App\Http\Controllers\Auth\ApiLoginController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\MessageController;


Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [ApiLoginController::class, 'login'])->name('login');

Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');


Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::get('/users', [UserController::class, 'index']);

    # Friends
    Route::post('/friends/{user}', [FriendController::class, 'request']);
    Route::post('/friends/{user}/accept', [FriendController::class, 'accept']);

    # Messages
    Route::post('/messages/{recipient}', [MessageController::class, 'send']);
    Route::get('/messages/{withUser}', [MessageController::class, 'search']);
    Route::get('/messages', [MessageController::class, 'all']);
});
