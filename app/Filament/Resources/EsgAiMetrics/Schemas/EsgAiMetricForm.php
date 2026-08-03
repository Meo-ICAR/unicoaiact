<?php

namespace App\Filament\Resources\EsgAiMetrics\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EsgAiMetricForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('ai_system_id')
                    ->relationship('aiSystem', 'name')
                    ->required(),
                TextInput::make('estimated_kwh_consumption')
                    ->numeric(),
                TextInput::make('carbon_footprint_kg')
                    ->numeric(),
                TextInput::make('ethical_governance_score')
                    ->numeric(),
            ]);
    }
}
