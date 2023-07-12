<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Room;
use App\Models\User;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Building;
use App\Models\Classroom;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        DB::table('user_types')->insert([
            [
                'name' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'teacher',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'student',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        User::create([
            'username' => 'admin',
            'password' => bcrypt('password'),
            'first_name' => 'admin',
            'last_name' => 'admin',
            'sex' => 1,
            'user_type_id' => 1,
        ]);

        User::create([
            'username' => 'teacher',
            'password' => bcrypt('password'),
            'first_name' => 'admin',
            'last_name' => 'admin',
            'sex' => 1,
            'user_type_id' => 2,
        ]);

        User::create([
            'username' => 'student',
            'password' => bcrypt('password'),
            'first_name' => 'admin',
            'last_name' => 'admin',
            'sex' => 1,
            'user_type_id' => 3,
        ]);

        DB::table('honorifics')->insert([
            [
                'honorific' => 'Mr.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'honorific' => 'Mrs.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'honorific' => 'Ms.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'honorific' => 'Mx.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);


        for ($i = 1; $i <= 10; $i++) {
            DB::table('grade_levels')->insert([
                [
                    'gr_level' => strval($i),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }

        DB::table('grade_levels')->insert([
            [
                'gr_level' => 'All',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'gr_level' => 'Not Applicable',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('subject_types')->insert([
            [
                'type' => 'Academic',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'Non-Academic',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'Break',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $default_subjects = [
            ['Mathematics', 1],
            ['English', 1],
            ['Science', 1],
            ['Mother Tongue', 1],
            ['Araling Panlipunan', 1],
            ['Filipino', 1],
            ['Music', 1],
            ['Arts', 1],
            ['Physical Education', 1],
            ['Health', 1],
            ['MAPEH', 1],
            ['Edukasyong Pantahanan at Pangkabuhayan (EPP)', 1],
            ['Technology Livelihood Education (TLE)', 1],
            ['Edukasyon sa Pagpapakatao (EsP)', 1],
            ['Flag Ceremony', 2],
            ['Homeroom', 2],
            ['Clubs', 2],
            ['Break', 3],
            ['Recess', 3],
            ['Lunch', 3],
            ['Not Applicable', null],
            ['ALL', null],
        ];

        foreach ($default_subjects as $default_subject) {
            DB::table('default_subjects')->insert([
                [
                    'name' => $default_subject[0],
                    'subject_type_id' => $default_subject[1],
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }

        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        foreach ($days as $day) {
            DB::table('days')->insert([
                [
                    'name' => $day,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }

        Building::factory()->count(2)->create();
        Room::factory()->count(50)->create();
        Classroom::factory()->count(50)->create();
        Subject::factory()->count(140)->create();
        Teacher::factory()->count(35)->create();
    }
}
