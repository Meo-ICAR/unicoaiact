<?php

namespace App\Filament\Resources\AiSystems\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AiSystemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('organization_id')
                    ->relationship('organization', 'name'),
                TextInput::make('name')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('version')
                    ->required()
                    ->default('1.0.0'),
                Select::make('owner_id')
                    ->relationship('owner', 'name')
                    ->required(),
                Toggle::make('is_shadow_ai')
                    ->required(),
                TextInput::make('discovery_method'),
                Select::make('approval_status')
                    ->options([
            'draft' => 'Draft',
            'pending_approval' => 'Pending approval',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
        ])
                    ->default('draft')
                    ->required(),
                Select::make('human_oversight_type')
                    ->options([
            'human_in_the_loop' => 'Human in the loop',
            'human_on_the_loop' => 'Human on the loop',
            'human_in_command' => 'Human in command',
        ]),
                Toggle::make('has_kill_switch')
                    ->required(),
                Textarea::make('kill_switch_procedure')
                    ->columnSpanFull(),
                TextInput::make('eu_db_registration_id'),
                Select::make('eu_registration_status')
                    ->options(['not_required' => 'Not required', 'pending' => 'Pending', 'registered' => 'Registered'])
                    ->default('not_required')
                    ->required(),
            ]);
    }
}
