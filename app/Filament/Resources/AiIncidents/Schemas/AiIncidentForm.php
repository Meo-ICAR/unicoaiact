<?php

namespace App\Filament\Resources\AiIncidents\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AiIncidentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('ai_system_id')
                    ->relationship('aiSystem', 'name')
                    ->required(),
                TextInput::make('incident_type')
                    ->required(),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                Select::make('severity')
                    ->options(['low' => 'Low', 'medium' => 'Medium', 'high' => 'High', 'critical' => 'Critical'])
                    ->default('low')
                    ->required(),
                Toggle::make('reported_to_authority')
                    ->required(),
                DateTimePicker::make('authority_notified_at'),
                TextInput::make('authority_reference_code'),
                DateTimePicker::make('reported_at')
                    ->required(),
                DateTimePicker::make('resolved_at'),
            ]);
    }
}
