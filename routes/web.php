<?php

declare(strict_types=1);

use App\Http\Controllers\HabitController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => config('app.name'));

Route::prefix('/api')->name('api.')->group(function () {
    Route::resource('habits', HabitController::class)->scoped(['habit' => 'uuid']);
});
