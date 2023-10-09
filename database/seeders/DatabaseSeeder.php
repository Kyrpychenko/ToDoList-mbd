<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            "password" => Hash::make("admin"),
            "role" => "admin",
        ]);
        \App\Models\User::factory()->create([
            'name' => 'user',
            'email' => 'user@user.com',
            "password" => Hash::make("user"),
            "role" => "user"
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Moderator',
            'email' => 'mod@mod.com',
            'password' =>  Hash::make('mod'),
            'role' => 'moderator',
        ]);
        \App\Models\TodoListUserAssignment::factory()->count(3)->create([]);
        \App\Models\TodoItem::factory()->count(5)->create([]);
        \App\Models\TodoList::factory()->count(5)->create([]);
        \App\Models\User::factory()->count(5)->create([]);
    }
}
