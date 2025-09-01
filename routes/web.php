<?php

declare(strict_types = 1);

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => config('app.name'));

Route::middleware('guest')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
});
