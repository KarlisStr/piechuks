<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lokacijas;

class LokacijasSeeder extends Seeder
{
    public function run()
    {
        $locations = [
            ['lokacijas_id' => 1, 'adrese' => 'Rīgas iela 10-3, 1010 Rīga'],
            ['lokacijas_id' => 2, 'adrese' => 'Liepājas iela 25, 3001 Jūrmala'],
            ['lokacijas_id' => 3, 'adrese' => 'Brīvības iela 5, 2000 Rīga'],
        ];

        foreach ($locations as $location) {
            $parts = explode(', ', $location['adrese']);
            $city = array_pop($parts);

            Lokacijas::create([
                'lokacijas_id' => $location['lokacijas_id'],
                'adrese' => $location['adrese'],
                'apraksts' => '',
                'pilseta' => $city,
            ]);
        }
    }
}
