<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AlternativeCriteria;

class AlternativeCriteriaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [

            // AI
            ['alternative_id' => 1, 'criteria_id' => 1, 'nilai' => 5],
            ['alternative_id' => 1, 'criteria_id' => 2, 'nilai' => 5],
            ['alternative_id' => 1, 'criteria_id' => 3, 'nilai' => 5],
            ['alternative_id' => 1, 'criteria_id' => 4, 'nilai' => 4],
            ['alternative_id' => 1, 'criteria_id' => 5, 'nilai' => 5],

            // Web Dev
            ['alternative_id' => 2, 'criteria_id' => 1, 'nilai' => 4],
            ['alternative_id' => 2, 'criteria_id' => 2, 'nilai' => 5],
            ['alternative_id' => 2, 'criteria_id' => 3, 'nilai' => 4],
            ['alternative_id' => 2, 'criteria_id' => 4, 'nilai' => 5],
            ['alternative_id' => 2, 'criteria_id' => 5, 'nilai' => 4],

            // Mobile
            ['alternative_id' => 3, 'criteria_id' => 1, 'nilai' => 4],
            ['alternative_id' => 3, 'criteria_id' => 2, 'nilai' => 5],
            ['alternative_id' => 3, 'criteria_id' => 3, 'nilai' => 4],
            ['alternative_id' => 3, 'criteria_id' => 4, 'nilai' => 4],
            ['alternative_id' => 3, 'criteria_id' => 5, 'nilai' => 4],

            // Cyber Security
            ['alternative_id' => 4, 'criteria_id' => 1, 'nilai' => 4],
            ['alternative_id' => 4, 'criteria_id' => 2, 'nilai' => 5],
            ['alternative_id' => 4, 'criteria_id' => 3, 'nilai' => 5],
            ['alternative_id' => 4, 'criteria_id' => 4, 'nilai' => 4],
            ['alternative_id' => 4, 'criteria_id' => 5, 'nilai' => 5],

            // Data Science
            ['alternative_id' => 5, 'criteria_id' => 1, 'nilai' => 5],
            ['alternative_id' => 5, 'criteria_id' => 2, 'nilai' => 4],
            ['alternative_id' => 5, 'criteria_id' => 3, 'nilai' => 5],
            ['alternative_id' => 5, 'criteria_id' => 4, 'nilai' => 3],
            ['alternative_id' => 5, 'criteria_id' => 5, 'nilai' => 5],

            // IoT
            ['alternative_id' => 6, 'criteria_id' => 1, 'nilai' => 4],
            ['alternative_id' => 6, 'criteria_id' => 2, 'nilai' => 4],
            ['alternative_id' => 6, 'criteria_id' => 3, 'nilai' => 4],
            ['alternative_id' => 6, 'criteria_id' => 4, 'nilai' => 5],
            ['alternative_id' => 6, 'criteria_id' => 5, 'nilai' => 4],

            // UI/UX
            ['alternative_id' => 7, 'criteria_id' => 1, 'nilai' => 5],
            ['alternative_id' => 7, 'criteria_id' => 2, 'nilai' => 2],
            ['alternative_id' => 7, 'criteria_id' => 3, 'nilai' => 3],
            ['alternative_id' => 7, 'criteria_id' => 4, 'nilai' => 4],
            ['alternative_id' => 7, 'criteria_id' => 5, 'nilai' => 4],

            // Networking
            ['alternative_id' => 8, 'criteria_id' => 1, 'nilai' => 3],
            ['alternative_id' => 8, 'criteria_id' => 2, 'nilai' => 4],
            ['alternative_id' => 8, 'criteria_id' => 3, 'nilai' => 4],
            ['alternative_id' => 8, 'criteria_id' => 4, 'nilai' => 4],
            ['alternative_id' => 8, 'criteria_id' => 5, 'nilai' => 4],
        ];

        foreach ($data as $item) {
            AlternativeCriteria::create($item);
        }
    }
}
