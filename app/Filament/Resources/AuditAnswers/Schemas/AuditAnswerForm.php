<?php

namespace App\Filament\Resources\AuditAnswers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AuditAnswerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('audit_id')
                    ->relationship('audit', 'id')
                    ->required(),
                TextInput::make('framework_requirement_id')
                    ->required()
                    ->numeric(),
                Toggle::make('is_compliant'),
                Textarea::make('notes')
                    ->columnSpanFull(),
                TextInput::make('payload'),
            ]);
    }
}
