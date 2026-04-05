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
        User::create([
            'name' => 'Mohammad Alief Hasyani',
            'email' => 'aliefhasyani@gmail.com',
            'password' => '2830121262',
            'role' => 'officer'
        ]);
    }
}
