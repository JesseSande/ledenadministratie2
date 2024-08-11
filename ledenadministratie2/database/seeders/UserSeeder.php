<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Penningmeester',
            'email' => 'jessevdsande96@gmail.com',
            'password' => Hash::make('demodemo123'), 
            'username' => 'JohnDoe', 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
