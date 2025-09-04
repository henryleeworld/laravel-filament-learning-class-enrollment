<?php

namespace Database\Seeders;

use App\Models\ClassSchedule;
use App\Models\LearningClass;
use App\Models\User;
use Illuminate\Database\Seeder;

class ClassScheduleSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        $learningClasses = LearningClass::all();
        $teachers = User::whereHas('role', function ($query) {
            $query->where('name', 'Teacher');
        })->get();

        ClassSchedule::factory()->count(30)->create([
            'learning_class_id' => $learningClasses->random()->id,
            'teacher_id' => $teachers->random()->id,
        ]);
    }
}
