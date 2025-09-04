<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClassSchedule extends Model
{
    /** @use HasFactory<\Database\Factories\ClassScheduleFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'learning_class_id',
        'scheduled_date',
        'start_time',
        'end_time',
        'teacher_id',
        'substitute_teacher_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'scheduled_date' => 'date',
        ];
    }

    /**
     * Get the learning class that owns the class schedule.
     */
    public function learningClass(): BelongsTo
    {
        return $this->belongsTo(LearningClass::class);
    }

    /**
     * Get the teacher that owns the class schedule.
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Get the substitute teacher that owns the class schedule.
     */
    public function substituteTeacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'substitute_teacher_id');
    }

    /**
     * Get the attendances for the class schedule.
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Get the teacher payouts for the class schedule.
     */
    public function teacherPayouts(): HasMany
    {
        return $this->hasMany(TeacherPayout::class);
    }
}
