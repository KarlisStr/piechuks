<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pakalpojumi;

class PakalpojumiSeeder extends Seeder
{
    public function run()
    {

        Pakalpojumi::create([
            'pakalpojuma_id' =>39,
            'nosaukums' => 'Plumbing Services',
            'apraksts' => 'Plumbing Services',
            'kategorijas_nosaukums' => 'Mājas Pakalpojumi',
            'cena' => 50,
            'adrese' => 'Baker Street 221B, Rīga',
            'profesionalis_id' => '1',
        ]);

        Pakalpojumi::create([
            'pakalpojuma_id' =>38,
            'nosaukums' => 'Plumbing Services',
            'apraksts' => 'Plumbing Services',
            'kategorijas_nosaukums' => 'Mājas Pakalpojumi',
            'cena' => 50,
            'adrese' => 'Baker Street 221B, Rīga',
            'profesionalis_id' => '1',
        ]);
        Pakalpojumi::create([
            'pakalpojuma_id' =>37,
            'nosaukums' => 'Plumbasding Services',
            'apraksts' => 'Plumbing Services',
            'kategorijas_nosaukums' => 'Mājas Pakalpojumi',
            'cena' => 50,
            'adrese' => 'Baker Street 221B, Rīga',
            'profesionalis_id' => '1',
        ]);
        Pakalpojumi::create([
            'pakalpojuma_id' =>36,
            'nosaukums' => 'Plumbing Services',
            'apraksts' => 'Plumbing Services',
            'kategorijas_nosaukums' => 'Mājas Pakalpojumi',
            'cena' => 50,
            'adrese' => 'Baker Street 221B, Rīga',
            'profesionalis_id' => '1',
        ]);
        Pakalpojumi::create([
            'pakalpojuma_id' =>35,
            'nosaukums' => 'Plumbing Services',
            'apraksts' => 'Plumbing Services',
            'kategorijas_nosaukums' => 'Mājas Pakalpojumi',
            'cena' => 50,
            'adrese' => 'Baker Street 221B, Rīga',
            'profesionalis_id' => '1',
        ]);
        Pakalpojumi::create([
            'pakalpojuma_id' =>34,
            'nosaukums' => 'Plumbing Services',
            'apraksts' => 'Plumbing Services',
            'kategorijas_nosaukums' => 'Mājas Pakalpojumi',
            'cena' => 50,
            'adrese' => 'Baker Street 221B, Rīga',
            'profesionalis_id' => '1',
        ]);
    }
}
