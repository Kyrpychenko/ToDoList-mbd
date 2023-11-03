<?php

namespace Database\Seeders;


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



        \App\Models\TodoList::factory()->count(6)
            ->has(
                \App\Models\TodoItem::factory()->count(3)
            )
            ->create([]);

        $admin->todoItems()->attach(\App\Models\TodoItem::limit(5)->get());
        $user->todoItems()->attach(\App\Models\TodoItem::offset(3)->limit(5)->get());

        $admin->todoLists()->attach(\App\Models\TodoList::limit(5)->get());
        $user->todoLists()->attach(\App\Models\TodoList::offset(3)->limit(5)->get());
    }
}
