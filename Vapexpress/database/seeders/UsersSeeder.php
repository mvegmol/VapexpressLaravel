<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        DB::table('users')->insert([
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'email_verified_at' => Carbon::now(),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => Hash::make('password456'),
                'role' => 'user',
                'email_verified_at' => Carbon::now(),
            ],
            [
                'name' => 'Miguel',
                'email' => 'miguelvegamolina2404@gmail.com',
                'password' => Hash::make('@Fiona123'),
                'role' => 'admin',
                'email_verified_at' => Carbon::now(),
            ],
        ]);
    }
}
