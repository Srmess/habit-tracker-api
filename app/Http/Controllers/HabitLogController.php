<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreHabitLogRequest;
use App\Http\Resources\HabitLogResource;
use App\Models\Habit;
use App\Models\HabitLog;

class HabitLogController extends Controller
{
    public function index(Habit $habit)
    {
        return HabitLogResource::collection(
            $habit->logs()->paginate()
        );
    }

    public function store(StoreHabitLogRequest $request, Habit $habit)
    {
        $log = $habit->logs()->updateOrCreate(
            [
                'completed_at' => $request->date('completed_at'),
            ],
        );

        return HabitLogResource::make($log);
    }

    public function show(Habit $habit, HabitLog $log)
    {
        request()->validate([
            'with' => ['string', 'nullable', 'regex:/\b(?:logs|user)(?:.*\b(?:logs|user))?/i'],
        ]);

        return HabitLogResource::make(
            $log->load(['habit'])
        );
    }

    public function destroy(Habit $habit, HabitLog $log)
    {
        $log->delete();

        return response()->noContent();
    }
}
