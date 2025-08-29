<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreHabitLogRequest;
use App\Http\Resources\HabitLogResource;
use App\Models\Habit;
use App\Models\HabitLog;
use Illuminate\Http\Request;

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

    public function show(HabitLog $habitLog)
    {
        //
    }

    public function update(Request $request, HabitLog $habitLog)
    {
        //
    }

    public function destroy(HabitLog $habitLog)
    {
        //
    }
}
