<?php

namespace App\Filament\Resources\LearningClasses\Schemas;

use App\Models\ClassType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LearningClassForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('class_type_id')
                    ->label(__('Class type'))
                    ->relationship('classType', 'name')
                    ->getOptionLabelFromRecordUsing(fn (ClassType $record) => __($record->name))
                    ->required(),
                TextInput::make('name')
                    ->label(__('Name'))
                    ->required(),
                Textarea::make('description')
                    ->label(__('Description'))
                    ->columnSpanFull(),
                TextInput::make('price_per_student')
                    ->label(__('Price per student'))
                    ->numeric()
                    ->prefix('NT$') // ->prefix('$')
                    ->step(1) // ->step(0.01)
                    ->required(),
            ]);
    }
}
