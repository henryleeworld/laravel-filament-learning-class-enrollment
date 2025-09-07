<?php

namespace App\Filament\Resources\ClassSchedules\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ClassSchedulesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('learningClass.name')
                    ->label(__('Learning class'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('scheduled_date')
                    ->label(__('Scheduled date'))
                    ->date()
                    ->sortable(),
                TextColumn::make('start_time')
                    ->label(__('Start time'))
                    ->time()
                    ->sortable(),
                TextColumn::make('end_time')
                    ->label(__('End time'))
                    ->time()
                    ->sortable(),
                TextColumn::make('teacher.name')
                    ->label(__('Teacher'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('substituteTeacher.name')
                    ->label(__('Substitute teacher'))
                    ->sortable()
                    ->searchable()
                    ->placeholder('—'),
                TextColumn::make('created_at')
                    ->label(__('Created at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(__('Updated at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('learning_class_id')
                    ->label(__('Learning class'))
                    ->relationship('learningClass', 'name'),
                SelectFilter::make('teacher_id')
                    ->label(__('Teacher'))
                    ->relationship('teacher', 'name'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('scheduled_date', 'asc');
    }
}
