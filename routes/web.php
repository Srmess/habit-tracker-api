<?php

declare(strict_types = 1);

use App\Http\Controllers\HabitController;
use App\Http\Controllers\HabitLogController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => config('app.name'));

Route::prefix('/api')->name('api.')->group(function (): void {
    Route::apiResource('habits', HabitController::class)->scoped(['habit' => 'uuid']);

    Route::get('habits/{habit:uuid}/logs', [HabitLogController::class, 'index'])->name('habits.logs.index');
    Route::post('habits/{habit:uuid}/logs', [HabitLogController::class, 'store'])->name('habits.logs.store');
    Route::delete('habits/{habit:uuid}/logs/{log:uuid}', [HabitLogController::class, 'destroy'])->name('habits.logs.destroy');
});
