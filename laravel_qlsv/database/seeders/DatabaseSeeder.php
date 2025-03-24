<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create roles
        DB::table('roles')->insert([
            ['name' => 'teacher'],
            ['name' => 'student']
        ]);

        // Create users
        $users = [
            [
                'name' => 'Teacher 1',
                'email' => 'teacher1@example.com',
                'username' => 'teacher1',
                'password' => Hash::make('123456a@A'),
                'role_id' => 1,
            ],
            [
                'name' => 'Teacher 2', 
                'email' => 'teacher2@example.com',
                'username' => 'teacher2',
                'password' => Hash::make('123456a@A'),
                'role_id' => 1,
            ],
            [
                'name' => 'Student 1',
                'email' => 'student1@example.com', 
                'username' => 'student1',
                'password' => Hash::make('123456a@A'),
                'role_id' => 2,
            ],
            [
                'name' => 'Student 2',
                'email' => 'student2@example.com',
                'username' => 'student2', 
                'password' => Hash::make('123456a@A'),
                'role_id' => 2,
            ]
        ];

        foreach ($users as $user) {
            DB::table('users')->insert($user);
        }
    }
}
