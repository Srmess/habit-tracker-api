<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreHabitRequest;
use App\Http\Requests\UpdateHabitRequest;
use App\Http\Resources\HabitResource;
use App\Models\Habit;
use Illuminate\Contracts\Database\Eloquent\Builder;

class HabitController extends Controller
{
    public function index()
    {
        $hasLogs = str(request()->string('with', ''))->contains('logs');
        $hasUser = str(request()->string('with', ''))->contains('user');

        $habits = Habit::query()
            ->when($hasLogs, fn (Builder $query) => $query->with('logs'))
            ->when($hasUser, fn (Builder $query) => $query->with('user'))
            ->paginate();

        return HabitResource::collection($habits);
    }

    public function store(StoreHabitRequest $request)
    {
        $payload = $request->only(['title', 'uuid']);

        $habit = Habit::create(array_merge($payload, ['user_id' => 11]));

        return HabitResource::make($habit);
    }

    public function show(Habit $habit)
    {
        return HabitResource::make($habit);
    }

    public function update(UpdateHabitRequest $request, Habit $habit)
    {
        $payload = $request->only(['title', 'uuid']);

        $habit->update($payload);

        return HabitResource::make($habit);
    }

    public function destroy(Habit $habit)
    {
        $habit->delete();

        return response()->noContent();
    }
}
