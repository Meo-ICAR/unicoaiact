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
            ]);
    }
}
