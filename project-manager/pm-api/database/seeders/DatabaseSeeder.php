<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Nelson Vásquez',
            'email' => 'nelson.o.vasquez@gmail.com',
            'password' => Hash::make('Cyb3rn3lsk8')
        ]);

        Status::create([
            'name' => 'Pending'
        ]);
        
        Status::create([
            'name' => 'In Progress'
        ]);

        Status::create([
            'name' => 'Working'
        ]);

        Status::create([
            'name' => 'Complete'
        ]);
    }
}
