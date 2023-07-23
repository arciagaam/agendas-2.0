<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class TeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create([
            'user_type_id' => 2,
        ]);

        return [
            'user_id' => $user->id,
            'honorific_id' => fake()->numberBetween(1,4),
            'max_hours' => 14,
            'regular_load' => 10,
            'is_available' => 1,
        ];
    }
}
