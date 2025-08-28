<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHabitRequest;
use App\Http\Requests\UpdateHabitRequest;
use App\Http\Resources\HabitResource;
use App\Models\Habit;
use Illuminate\Http\Request;

class HabitController extends Controller
{
    public function index()
    {
        $habits = Habit::all();

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
