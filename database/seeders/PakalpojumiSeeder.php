<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pakalpojumi;

class PakalpojumiSeeder extends Seeder
{
    public function run()
    {
        // Add pakalpojumi for each profesionalis
        Pakalpojumi::create([
            'pakalpojuma_id' => 1,
            'apraksts' => 'Plumbing Services',
            'kategorijas_nosaukums' => 'Home Services',
            'cena' => 50,
            'adrese' => 'Baker Street 221B, Rīga',
            'profesionalis_id' => '2',
        ]);

        Pakalpojumi::create([
            'pakalpojuma_id' => 2,
            'apraksts' => 'Electrical Services',
            'kategorijas_nosaukums' => 'Home Services',
            'cena' => 60,
            'adrese' => 'asd, Rīga',
            'profesionalis_id' => '1',
        ]);

        Pakalpojumi::create([
            'pakalpojuma_id' => 3,
            'apraksts' => 'Cleaning Services',
            'kategorijas_nosaukums' => 'Home Services',
            'cena' => 40,
            'adrese' => 'asd, Rīga',
            'profesionalis_id' => '3',
        ]);
    }
}
