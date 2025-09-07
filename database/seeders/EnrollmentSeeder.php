<?php

namespace Database\Seeders;

use App\Models\Enrollment;
use App\Models\LearningClass;
use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        $startDay = Carbon::now()->startOfDay();
        $fifteenDaysLater = $startDay->copy()->addDays(15);
		$twoMonthsLater = $startDay->copy()->addMonths(2);
        $threeAndHalfMonthsLater = $startDay->copy()->addMonths(3.5);
        $students = Student::all();
        $learningClasses = LearningClass::all();
        foreach ($learningClasses as $class) {
            $numberOfStudents = fake()->numberBetween(3, 8);
            $enrolledStudents = $students->random($numberOfStudents);
            
            foreach ($enrolledStudents as $student) {
                if (!Enrollment::where('student_id', $student->id)
                    ->where('learning_class_id', $class->id)
                    ->exists()) {
                    
                    Enrollment::create([
                        'student_id' => $student->id,
                        'learning_class_id' => $class->id,
                        'start_date' => $startDay,
                        'end_date' => $threeAndHalfMonthsLater,
                    ]);
                }
            }
        }
        $additionalEnrollments = fake()->numberBetween(10, 20);
        for ($i = 0; $i < $additionalEnrollments; $i++) {
            $student = $students->random();
            $class = $learningClasses->random();

            if (!Enrollment::where('student_id', $student->id)
                ->where('learning_class_id', $class->id)
                ->exists()) {
                
                Enrollment::create([
                    'student_id' => $student->id,
                    'learning_class_id' => $class->id,
                    'start_date' => fake()->dateTimeBetween($startDay, $fifteenDaysLater)->format('Y-m-d'),
                    'end_date' => fake()->dateTimeBetween($twoMonthsLater, $threeAndHalfMonthsLater)->format('Y-m-d'),
                ]);
            }
        }
    }
}
