<?php

namespace App\Filament\Resources\AiModels\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AiModelForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('provider')
                    ->required(),
                TextInput::make('hosting_type')
                    ->required(),
                Toggle::make('is_third_party')
                    ->required(),
            ]);
    }
}
