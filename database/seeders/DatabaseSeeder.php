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
    }
}
