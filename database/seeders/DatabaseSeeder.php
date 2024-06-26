<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(AdminSeeder::class);
        $this->call(ProfesionaliSeeder::class);
        $this->call(PakalpojumiSeeder::class);
    }
}
