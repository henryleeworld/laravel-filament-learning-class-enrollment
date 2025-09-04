<?php

namespace Database\Seeders;

use App\Models\ClassSchedule;
use App\Models\TeacherPayout;
use App\Models\User;
use Illuminate\Database\Seeder;

class TeacherPayoutSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        $classSchedules = ClassSchedule::all();
        $teachers = User::whereHas('role', function ($query) {
            $query->where('name', 'Teacher');
        })->get();

        TeacherPayout::factory()->count(40)->create([
            'class_schedule_id' => $classSchedules->random()->id,
            'teacher_id' => $teachers->random()->id,
        ]);
    }
}
