<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Admin User
        User::factory()->create([
            "name" => "Administrator",
            "email" => "admin@admin.com",
            "password" => Hash::make("password")
        ])->assignRole("admin");

        // Create Moderator User
        User::factory()->create([
            "name" => "Moderator",
            "email" => "moderator@moderator.com",
            "password" => Hash::make("password")
        ])->assignRole("moderator");

        // Create Author User
        User::factory()->create([
            "name" => "Author",
            "email" => "author@author.com",
            "password" => Hash::make("password")
        ])->assignRole("author");

        // Create Users
        User::factory()->count(10)->create();
    }
}
