<?php

namespace App\Filament\Resources\ComplianceFrameworks\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ComplianceFrameworkForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->required(),
                TextInput::make('title')
                    ->required(),
                TextInput::make('version')
                    ->required(),
                TextInput::make('compliance_threshold_percentage')
                    ->label('Soglia di conformità (%)')
                    ->helperText('Percentuale minima di risposte conformi sotto la quale un Audit su questo framework è marcato "non conforme".')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->default(80)
                    ->required(),
            ]);
    }
}
