<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Building>
 */
class SubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        static $defaultSubjectId = 1; // Start with default_subject_id = 1
        static $gradeLevelId = 1;

        $subjectId = $defaultSubjectId++;
        $grLevelId = $gradeLevelId;

        if ($defaultSubjectId > 14) {
            $defaultSubjectId = 1; // Reset default_subject_id to 1 after reaching 14
            $gradeLevelId++;
        }


        if ($gradeLevelId > 10) {
            $gradeLevelId = 1;
        }

        

        return [
            'subject_name' => 'Subject ' . $this->faker->colorName(),
            'subject_code' => 'Subj-'.$this->faker->numberBetween(10, 99),
            'subject_description' => null,
            'default_subject_id' => $subjectId,
            'gr_level_id' => $grLevelId,
            'sp_frequency' => 5,
            'dp_frequency' => 0,
        ];
    }
}
