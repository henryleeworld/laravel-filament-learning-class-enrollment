<?php

namespace App\Filament\Resources\LearningClasses\Pages;

use App\Filament\Resources\LearningClasses\LearningClassResource;
use App\Models\Attendance;
use App\Models\ClassSchedule;
use App\Models\LearningClass;
use App\Models\Student;
use BackedEnum;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ManageMonthlyAttendance extends Page implements HasForms
{
    use InteractsWithForms, InteractsWithRecord;

    protected static string $resource = LearningClassResource::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static bool $shouldRegisterNavigation = false;

    public string $selectedMonth;

    public array $attendanceData = [];

    protected function getActions(): array
    {
        return [
            Action::make('back')
                ->label(__('Back to classes'))
                ->url(LearningClassResource::getUrl('index'))
                ->color('gray'),
        ];
    }

    public function getClassSchedulesForMonth(): Collection
    {
        $monthStart = Carbon::createFromFormat('Y-m', $this->selectedMonth)->startOfMonth();
        $monthEnd = Carbon::createFromFormat('Y-m', $this->selectedMonth)->endOfMonth();

        return ClassSchedule::where('learning_class_id', $this->record->id)
            ->whereBetween('scheduled_date', [$monthStart, $monthEnd])
            ->orderBy('scheduled_date')
            ->orderBy('start_time')
            ->get();
    }

    public function getEnrolledStudents(): Collection
    {
        $monthStart = Carbon::createFromFormat('Y-m', $this->selectedMonth)->startOfMonth();
        $monthEnd = Carbon::createFromFormat('Y-m', $this->selectedMonth)->endOfMonth();

        return Student::whereHas('enrollments', function ($query) use ($monthStart, $monthEnd) {
            $query->where('learning_class_id', $this->record->id)
                ->where('start_date', '<=', $monthEnd)
                ->where(function ($q) use ($monthStart) {
                    $q->whereNull('end_date')
                        ->orWhere('end_date', '>=', $monthStart);
                });
        })->orderBy('name')->get();
    }

    public function getMonthOptions(): array
    {
        $options = [];
        $current = now()->startOfMonth();

        for ($i = -6; $i <= 6; $i++) {
            $date = $current->copy()->addMonths($i);
            $date->settings(['formatFunction' => 'translatedFormat']);
            $options[$date->format('Y-m')] = $date->locale(config('app.locale'))->format('F Y');
        }

        return $options;
    }

    public function getTitle(): string
    {
        return __('Manage attendance - ') . $this->record->name;
    }

    public function getView(): string
    {
        return 'filament.pages.manage-monthly-attendance';
    }

    protected function loadAttendanceData(): void
    {
        $students = $this->getEnrolledStudents();
        $classSchedules = $this->getClassSchedulesForMonth();

        $existingAttendance = Attendance::whereIn('class_schedule_id', $classSchedules->pluck('id'))
            ->whereIn('student_id', $students->pluck('id'))
            ->get()
            ->groupBy('student_id')
            ->map(fn ($attendances) => $attendances->keyBy('class_schedule_id'));

        foreach ($students as $student) {
            foreach ($classSchedules as $schedule) {
                $key = "{$student->id}-{$schedule->id}";
                $this->attendanceData[$key] = $existingAttendance->get($student->id)?->has($schedule->id) ? 'present' : 'absent';
            }
        }
    }

    public function mount(): void
    {
        if (is_string($this->record)) {
            $this->record = LearningClass::findOrFail($this->record);
        }
        
        $this->selectedMonth = request('month', now()->format('Y-m'));
        $this->loadAttendanceData();
    }

    public function save(): void
    {
        DB::transaction(function () {
            $students = $this->getEnrolledStudents();
            $classSchedules = $this->getClassSchedulesForMonth();

            foreach ($students as $student) {
                foreach ($classSchedules as $schedule) {
                    $key = "{$student->id}-{$schedule->id}";
                    $status = $this->attendanceData[$key] ?? 'absent';

                    if ($status === 'present') {
                        Attendance::updateOrCreate([
                            'class_schedule_id' => $schedule->id,
                            'student_id' => $student->id,
                        ]);
                    } else {
                        Attendance::where([
                            'class_schedule_id' => $schedule->id,
                            'student_id' => $student->id,
                        ])->delete();
                    }
                }
            }
        });

        Notification::make()
            ->title(__('Attendance saved successfully'))
            ->success()
            ->send();

        $this->loadAttendanceData();
    }

    public function updateMonth(): void
    {
        $this->redirect(LearningClassResource::getUrl('attendance', ['record' => $this->record, 'month' => $this->selectedMonth]));
    }
}
