<?php

namespace App\Filament\Resources\Audits\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AuditForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('ai_system_id')
                    ->relationship('aiSystem', 'name')
                    ->required(),
                TextInput::make('compliance_framework_id')
                    ->required()
                    ->numeric(),
                Select::make('status')
                    ->options([
            'draft' => 'Draft',
            'in_review' => 'In review',
            'compliant' => 'Compliant',
            'non_compliant' => 'Non compliant',
        ])
                    ->default('draft')
                    ->required(),
                TextInput::make('score_percentage')
                    ->numeric(),
            ]);
    }
}
