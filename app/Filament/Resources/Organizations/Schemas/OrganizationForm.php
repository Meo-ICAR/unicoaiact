<?php

namespace App\Filament\Resources\Organizations\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class OrganizationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('vat_number'),
                Select::make('type')
                    ->options([
            'company' => 'Company',
            'public_sector' => 'Public sector',
            'consultant_agency' => 'Consultant agency',
        ])
                    ->default('company')
                    ->required(),
            ]);
    }
}
