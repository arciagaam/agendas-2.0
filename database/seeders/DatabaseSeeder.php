<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
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

        $default_subjects = [
            'Mathematics',
            'English',
            'Science',
            'Mother Tongue',
            'Araling Panlipunan',
            'Filipino',
            'Music',
            'Arts',
            'Physical Education',
            'Health',
            'MAPEH',
            'Edukasyong Pantahanan at Pangkabuhayan (EPP)',
            'Technology Livelihood Education (TLE)',
            'Edukasyon sa Pagpapakatao (EsP)',
            'Homeroom',
            'Recess',
            'Lunch',
            'Not Applicable',
            'ALL',
        ];

        foreach ($default_subjects as $default_subject) {
            DB::table('default_subjects')->insert([
                [
                    'name' => $default_subject,
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
    }
}
