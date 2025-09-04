<?php

namespace Database\Seeders;

use App\Models\Enrollment;
use App\Models\LearningClass;
use App\Models\Student;
use Illuminate\Database\Seeder;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        $students = Student::all();
        $learningClasses = LearningClass::all();

        Enrollment::factory()->count(50)->create([
            'student_id' => $students->random()->id,
            'learning_class_id' => $learningClasses->random()->id,
        ]);
    }
}
