<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\ClassSchedule;
use App\Models\Student;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        $classSchedules = ClassSchedule::all();
        $students = Student::all();

        Attendance::factory()->count(80)->create([
            'class_schedule_id' => $classSchedules->random()->id,
            'student_id' => $students->random()->id,
        ]);
    }
}
