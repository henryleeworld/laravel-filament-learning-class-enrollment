<?php

namespace App\Filament\Resources\LearningClasses\Tables;

use App\Filament\Resources\LearningClasses\LearningClassResource;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LearningClassesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('classType.name')
                    ->label(__('Class type'))
                    ->formatStateUsing(fn (string $state): string => __($state))
                    ->searchable(),
                TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable(),
                TextColumn::make('price_per_student')
                    ->label(__('Price per student'))
                    ->money('TWD', decimalPlaces: 0) // ->money('USD')
                    ->sortable(),
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
                //
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('attendance')
                    ->label(__('Attendance'))
                    ->icon(Heroicon::ClipboardDocumentCheck)
                    ->color('success')
                    ->url(fn ($record) => LearningClassResource::getUrl('attendance', ['record' => $record])),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
