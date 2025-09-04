<?php

namespace App\Filament\Resources\ClassSchedules\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class ClassScheduleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('learning_class_id')
                    ->label(__('Learning class'))
                    ->relationship('learningClass', 'name')
                    ->searchable()
                    ->required(),
                DatePicker::make('scheduled_date')
                    ->label(__('Scheduled date'))
                    ->native(false)
                    ->required(),
                TimePicker::make('start_time')
                    ->label(__('Start time'))
                    ->native(false)
                    ->required(),
                TimePicker::make('end_time')
                    ->label(__('End time'))
                    ->native(false)
                    ->required(),
                Select::make('teacher_id')
                    ->label(__('Teacher'))
                    ->relationship('teacher', 'name')
                    ->searchable()
                    ->required(),
                Select::make('substitute_teacher_id')
                    ->label(__('Substitute teacher'))
                    ->relationship('substituteTeacher', 'name')
                    ->searchable()
                    ->nullable(),
            ]);
    }
}
