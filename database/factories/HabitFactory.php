<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Habit>
 */
class HabitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dailyHabits = [
            "Wake up early",
            "Drink a glass of water",
            "Exercise or stretch",
            "Eat a healthy breakfast",
            "Plan your day",
            "Read for 30 minutes",
            "Practice meditation or mindfulness",
            "Work on personal goals",
            "Take short breaks while working",
            "Stay hydrated throughout the day",
            "Eat balanced meals",
            "Go for a walk",
            "Limit social media usage",
            "Learn something new",
            "Practice gratitude",
            "Review your goals",
            "Spend time with family or friends",
            "Avoid junk food",
            "Reflect on your day",
            "Go to bed on time",
        ];

        return [
            'user_id' => User::factory(),
            'uuid'    => fake()->uuid(),
            'title'   => fake()->randomElement($dailyHabits),
        ];
    }
}
