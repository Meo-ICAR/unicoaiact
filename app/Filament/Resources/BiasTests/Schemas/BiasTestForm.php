<?php

namespace App\Filament\Resources\BiasTests\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BiasTestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('ai_system_id')
                    ->relationship('aiSystem', 'name')
                    ->required(),
                TextInput::make('test_name')
                    ->required(),
                TextInput::make('fairness_score')
                    ->numeric(),
                TextInput::make('drift_score')
                    ->numeric(),
                Toggle::make('passed')
                    ->required(),
                TextInput::make('metrics_payload'),
                DateTimePicker::make('tested_at')
                    ->required(),
            ]);
    }
}
