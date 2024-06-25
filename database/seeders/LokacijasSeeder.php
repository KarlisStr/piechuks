<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lokacijas;

class LokacijasSeeder extends Seeder
{
    public function run()
    {
        // Add locations
        Lokacijas::create([
            'lokacijas_id' => 1,
            'adrese' => 'Rīgas iela 10-3, 1010 Rīga',
            'apraksts' => '3. stāvs, dzīvoklis Nr. 10',
        ]);

        Lokacijas::create([
            'lokacijas_id' => 2,
            'adrese' => 'Liepājas iela 25, 3001 Jūrmala',
            'apraksts' => '1. stāvs, pagalms, 2. durvis pa labi',
        ]);

        Lokacijas::create([
            'lokacijas_id' => 3,
            'adrese' => 'Brīvības iela 5, 2000 Rīga',
            'apraksts' => '4. stāvs, kabinets Nr. 402',
        ]);
    }
}
