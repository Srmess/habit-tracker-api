<?php

declare(strict_types = 1);

use App\Http\Controllers\HabitController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => config('app.name'));

Route::prefix('/api')->name('api.')->group(function (): void {
    Route::apiResource('habits', HabitController::class)->scoped(['habit' => 'uuid']);

    Route::get('habits/{habits:uuid}/logs', [HabitController::class, 'index'])->name('habits.logs.index');
});
