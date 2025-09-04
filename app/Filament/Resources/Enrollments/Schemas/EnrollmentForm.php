<?php

namespace App\Filament\Resources\Enrollments\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EnrollmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Enrollment details'))
                    ->schema([
                        Select::make('student_id')
                            ->label(__('Student'))
                            ->relationship('student', 'name')
                            ->searchable()
                            ->required(),
                        Select::make('learning_class_id')
                            ->label(__('Learning class'))
                            ->relationship('learningClass', 'name')
                            ->searchable()
                            ->required(),
                        DatePicker::make('start_date')
                            ->label(__('Start date'))
                            ->required(),
                        DatePicker::make('end_date')
                            ->label(__('End date')),
                    ]),
            ]);
    }
}
