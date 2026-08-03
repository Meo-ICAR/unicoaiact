<?php

namespace App\Filament\Resources\RiskAssessments\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class RiskAssessmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('ai_system_id')
                    ->relationship('aiSystem', 'name')
                    ->required(),
                Select::make('risk_level')
                    ->options(['prohibited' => 'Prohibited', 'high' => 'High', 'limited' => 'Limited', 'minimal' => 'Minimal'])
                    ->required(),
                Textarea::make('justification')
                    ->required()
                    ->columnSpanFull(),
                Toggle::make('is_annex_iii')
                    ->required(),
                TextInput::make('evaluated_by')
                    ->required()
                    ->numeric(),
                DateTimePicker::make('completed_at'),
            ]);
    }
}
