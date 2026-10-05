<?php

namespace App\Filament\Resources\FriaAssessments\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class FriaAssessmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('ai_system_id')
                    ->relationship('aiSystem', 'name')
                    ->required(),
                TextInput::make('gdpr_dpia_id')
                    ->numeric(),
                Textarea::make('affected_categories')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('fundamental_rights_impact')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('mitigation_measures')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('assessed_by')
                    ->required()
                    ->numeric(),
                DateTimePicker::make('completed_at'),
            ]);
    }
}
