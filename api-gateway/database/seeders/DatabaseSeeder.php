<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Assign;
use App\Models\MemberType;
use App\Models\Cost;
use App\Models\Department;
use App\Models\Order;
use App\Models\Project;
use App\Models\ProjectType;
use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Department::factory()->count(3)->create();
        ProjectType::factory()->count(4)->create();
        Role::factory()->count(3)->create();
        Project::factory()->count(3)->create();
        Cost::factory()->count(3)->create();
        Order::factory()->count(3)->create();
        MemberType::factory()->count(3)->create();
        Assign::factory()->count(3)->create();
    }
}
