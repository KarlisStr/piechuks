<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Profesionali;
use Illuminate\Support\Facades\Hash;

class ProfesionaliSeeder extends Seeder
{
    public function run()
    {
        // Create users for each profesionalis
        $user1 = User::create([
            'name' => 'Jānis Bērziņš',
            'email' => 'janis.berzins@example.com',
            'password' => Hash::make('Password'),
        ]);

        $user2 = User::create([
            'name' => 'Anna Ābele',
            'email' => 'anna.abele@example.com',
            'password' => Hash::make('Password'),
        ]);

        $user3 = User::create([
            'name' => 'Pēteris Ozoliņš',
            'email' => 'peteris.ozolins@example.com',
            'password' => Hash::make('Password'),
        ]);

        // Create profesionali records and associate them with the users
        Profesionali::create([
            'profesionalis_id' => 'p1',
            'vards_uzvards' => 'Jānis Bērziņš',
            'epasts' => 'janis.berzins@example.com',
            'telefons' => '+371 20123456',
            'bankas_konts' => 'LV12HABA0012345678901',
            'statuss' => 8,
            'user_id' => $user1->id,
            'admin_id' => 'a1',
        ]);

        Profesionali::create([
            'profesionalis_id' => 'p2',
            'vards_uzvards' => 'Anna Ābele',
            'epasts' => 'anna.abele@example.com',
            'telefons' => '+371 20123457',
            'bankas_konts' => 'LV12SEBZ0012345678901',
            'statuss' => 6,
            'user_id' => $user2->id,
            'admin_id' => 'a1',
        ]);

        Profesionali::create([
            'profesionalis_id' => 'p3',
            'vards_uzvards' => 'Pēteris Ozoliņš',
            'epasts' => 'peteris.ozolins@example.com',
            'telefons' => '+371 20123458',
            'bankas_konts' => 'LV12CBBR0012345678901',
            'statuss' => 4,
            'user_id' => $user3->id,
            'admin_id' => 'a1',
        ]);
    }
}
