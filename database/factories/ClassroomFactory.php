<?php

namespace Database\Factories;

use App\Models\Classroom;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Classroom>
 */
class ClassroomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        static $numbers = [];
        if (count($numbers) == 0) {
            $numbers = range(1, 10);
            shuffle($numbers);
        }

        $number = array_shift($numbers);

        return [
            'room_id' => fake()->unique()->numberBetween(1, 50),
            'grade_level_id' => $number,
            'section' => fake()->firstName(),
        ];
    }
}
