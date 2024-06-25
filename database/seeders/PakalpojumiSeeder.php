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
            'cena' => '50 EUR',
            'lokacijas_id' => 1, // Assume lokacijas_id 1 exists
            'profesionalis_id' => 'p1',
        ]);

        Pakalpojumi::create([
            'pakalpojuma_id' => 2,
            'apraksts' => 'Electrical Services',
            'kategorijas_nosaukums' => 'Home Services',
            'cena' => '60 EUR',
            'lokacijas_id' => 2, // Assume lokacijas_id 2 exists
            'profesionalis_id' => 'p2',
        ]);

        Pakalpojumi::create([
            'pakalpojuma_id' => 3,
            'apraksts' => 'Cleaning Services',
            'kategorijas_nosaukums' => 'Home Services',
            'cena' => '40 EUR',
            'lokacijas_id' => 3, // Assume lokacijas_id 3 exists
            'profesionalis_id' => 'p3',
        ]);
    }
}
