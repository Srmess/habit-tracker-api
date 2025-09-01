<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreHabitRequest;
use App\Http\Requests\UpdateHabitRequest;
use App\Http\Resources\HabitResource;
use App\Models\Habit;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class HabitController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('can:own,habit', except:['index', 'store']),
        ];
    }

    public function index()
    {
        $hasLogs = str(request()->string('with', ''))->contains('logs');
        $hasUser = str(request()->string('with', ''))->contains('user');

        $habits = Habit::query()
            ->where('user_id', '=', auth()->id())
            ->when($hasLogs, fn (Builder $query) => $query->with('logs'))
            ->when($hasUser, fn (Builder $query) => $query->with('user'))
            ->paginate();

        return HabitResource::collection($habits);
    }

    public function store(StoreHabitRequest $request)
    {
        $habit = Habit::create(array_merge($request->validated(), ['user_id' => auth()->id()]));

        return HabitResource::make($habit);
    }

    public function show(Habit $habit)
    {
        request()->validate([
            'with' => ['string', 'nullable', 'regex:/\b(?:logs|user)(?:.*\b(?:logs|user))?/i'],
        ]);

        $queryParams = request()->string('with', '')->explode(',')->filter(fn ($word) => strlen($word) > 0)->toArray();

        return HabitResource::make($habit->load($queryParams));
    }

    public function update(UpdateHabitRequest $request, Habit $habit)
    {
        $habit->update($request->validated());

        return HabitResource::make($habit);
    }

    public function destroy(Habit $habit)
    {
        $habit->delete();

        return response()->noContent();
    }
}
