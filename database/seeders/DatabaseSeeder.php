<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        $admin = \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            "password" => Hash::make("admin"),
            "role" => "admin",
        ]);
        $user = \App\Models\User::factory()->create([
            'name' => 'user',
            'email' => 'user@user.com',
            "password" => Hash::make("user"),
            "role" => "user"
        ]);
        $mod = \App\Models\User::factory()->create([
            'name' => 'Moderator',
            'email' => 'mod@mod.com',
            'password' =>  Hash::make('mod'),
            'role' => 'moderator',
        ]);
        \App\Models\User::factory()->count(5)->create([]);



        \App\Models\TodoList::factory()->count(3)
            ->has(
                \App\Models\TodoItem::factory()->count(3)
                    ->has(\App\Models\TodoItemUserAssignment::factory([
                        'user_id' => $admin->id
                    ])->count(1))
            )
            ->create([]);

        \App\Models\TodoList::factory()->count(3)
            ->has(
                \App\Models\TodoItem::factory()->count(3)
                    ->has(\App\Models\TodoItemUserAssignment::factory([
                        'user_id' => $user->id
                    ])->count(1))
            )
            ->create([]);


        \App\Models\TodoList::factory()->count(3)
            ->has(\App\Models\TodoListUserAssignment::factory([
                'user_id' => $admin->id
            ])->count(3))
            ->create([]);

        \App\Models\TodoList::factory()->count(3)
            ->has(\App\Models\TodoListUserAssignment::factory([
                'user_id' => $user->id
            ])->count(3))
            ->create([]);
    }
}
