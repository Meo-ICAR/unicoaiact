<?php

namespace App\Filament\Resources\PqcSignatures\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PqcSignatureForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('signable_type')
                    ->required(),
                TextInput::make('signable_id')
                    ->required()
                    ->numeric(),
                TextInput::make('hash_algorithm')
                    ->required()
                    ->default('SHA3-512'),
                Textarea::make('data_hash')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('pqc_signature')
                    ->required()
                    ->columnSpanFull(),
                DateTimePicker::make('sealed_at')
                    ->required(),
            ]);
    }
}
