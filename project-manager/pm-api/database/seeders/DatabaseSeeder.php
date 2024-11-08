<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Project;
use App\Models\Status;
use App\Models\Task;
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

        User::create([
            'name' => 'Fulano de Tal',
            'email' => 'example@example.com',
            'password' => Hash::make('Cyb3rn3lsk8')
        ]);

        Project::create([
            'title' => 'Project example',
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolore accusantium vel deserunt nemo nam aliquam aliquid obcaecati vero esse impedit aperiam ab molestiae debitis, ratione facilis non eveniet, officiis quam?',
            'user_id' => 1
        ]);

        Project::create([
            'title' => 'Project example 2',
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolore accusantium vel deserunt nemo nam aliquam aliquid obcaecati vero esse impedit aperiam ab molestiae debitis, ratione facilis non eveniet, officiis quam?',
            'user_id' => 2
        ]);
        
        Project::create([
            'title' => 'Project example 3',
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolore accusantium vel deserunt nemo nam aliquam aliquid obcaecati vero esse impedit aperiam ab molestiae debitis, ratione facilis non eveniet, officiis quam?',
            'user_id' => 2
        ]);

        Status::create([
            'name' => 'Pending',
            'icon' => 'fas fa-cogs',
            'color' => 'gray-300'
        ]);
        
        Status::create([
            'name' => 'Working',
            'icon' => 'fas fa-person-digging',
            'color' => 'red-500'
        ]);

        Status::create([
            'name' => 'Complete',
            'icon' => 'fas fa-thumbs-up',
            'color' => 'green-500'
        ]);

        Task::create([
            'title' => 'Task 1',
            'description' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Reiciendis atque dolore illum architecto possimus placeat explicabo, tenetur, tempore laborum quaerat esse commodi quam repellat labore unde minus consectetur quae consequatur?',
            'user_id' => 1,
            'project_id' => 1,
            'status_id' => 2,
        ]);

        Task::create([
            'title' => 'Task 2',
            'description' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Reiciendis atque dolore illum architecto possimus placeat explicabo, tenetur, tempore laborum quaerat esse commodi quam repellat labore unde minus consectetur quae consequatur?',
            'user_id' => 1,
            'project_id' => 1,
            'status_id' => 1,
        ]);

        Task::create([
            'title' => 'Task 3',
            'description' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Reiciendis atque dolore illum architecto possimus placeat explicabo, tenetur, tempore laborum quaerat esse commodi quam repellat labore unde minus consectetur quae consequatur?',
            'user_id' => 1,
            'project_id' => 1,
            'status_id' => 1,
        ]);

        Task::create([
            'title' => 'Task user 2 ',
            'description' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Reiciendis atque dolore illum architecto possimus placeat explicabo, tenetur, tempore laborum quaerat esse commodi quam repellat labore unde minus consectetur quae consequatur?',
            'user_id' => 2,
            'project_id' => 1,
            'status_id' => 1,
        ]);

        Task::create([
            'title' => 'Task user 2 and project 2 ',
            'description' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Reiciendis atque dolore illum architecto possimus placeat explicabo, tenetur, tempore laborum quaerat esse commodi quam repellat labore unde minus consectetur quae consequatur?',
            'user_id' => 1,
            'project_id' => 2,
            'status_id' => 2,
        ]);
    }
}
