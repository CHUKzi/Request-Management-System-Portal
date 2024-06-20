<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user1 = User::create([
            'name' => 'Royan Harsha',
            'email' => 'royanharsha@outlook.com',
            'password' => bcrypt('royanharsha@outlook.com'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
