<?php

namespace App\Filament\Resources\AiSystems\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AiSystemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('organization.name')
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('version')
                    ->searchable(),
                TextColumn::make('owner.name')
                    ->searchable(),
                IconColumn::make('is_shadow_ai')
                    ->boolean(),
                TextColumn::make('discovery_method')
                    ->searchable(),
                TextColumn::make('approval_status')
                    ->badge(),
                TextColumn::make('human_oversight_type')
                    ->badge(),
                IconColumn::make('has_kill_switch')
                    ->boolean(),
                TextColumn::make('eu_db_registration_id')
                    ->searchable(),
                TextColumn::make('eu_registration_status')
                    ->badge(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
