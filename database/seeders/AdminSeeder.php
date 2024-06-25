<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Admin; // Make sure to import the Admin model
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Create a new user
        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@example.com', // Ensure the email is unique
            'password' => Hash::make('admin'),
        ]);

        // Create a new admin with the user_id
        Admin::create([
            'admin_id' => 'a1', // Use a unique admin_id
            'lietotajvards' => 'admin',
            'user_id' => $user->id,
        ]);
    }
}
