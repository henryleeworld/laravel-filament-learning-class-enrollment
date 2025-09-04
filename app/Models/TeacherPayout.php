<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeacherPayout extends Model
{
    /** @use HasFactory<\Database\Factories\TeacherPayoutFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'class_schedule_id',
        'teacher_id',
        'base_pay',
        'bonus_pay',
        'total_pay',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'base_pay' => 'decimal:2',
            'bonus_pay' => 'decimal:2',
            'total_pay' => 'decimal:2',
        ];
    }

    /**
     * Get the class schedule that owns the teacher payout.
     */
    public function classSchedule(): BelongsTo
    {
        return $this->belongsTo(ClassSchedule::class);
    }

    /**
     * Get the teacher that owns the teacher payout.
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
