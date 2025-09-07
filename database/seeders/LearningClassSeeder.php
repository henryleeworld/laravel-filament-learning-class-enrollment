<?php

namespace Database\Seeders;

use App\Models\ClassType;
use App\Models\LearningClass;
use Illuminate\Database\Seeder;

class LearningClassSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        $groupType = ClassType::where('name', 'Group')->first();
        $oneOnOneType = ClassType::where('name', 'One on one')->first();

        LearningClass::factory()->count(8)->create([
            'class_type_id' => $groupType->id,
        ]);

        LearningClass::factory()->count(5)->create([
            'class_type_id' => $oneOnOneType->id,
        ]);
    }
}
