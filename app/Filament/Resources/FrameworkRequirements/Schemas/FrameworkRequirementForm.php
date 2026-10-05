<?php

namespace App\Filament\Resources\FrameworkRequirements\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class FrameworkRequirementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('compliance_framework_id')
                    ->relationship('complianceFramework', 'title')
                    ->required(),
                TextInput::make('section_code')
                    ->required(),
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('applicable_risk_levels')
                    ->required(),
            ]);
    }
}
