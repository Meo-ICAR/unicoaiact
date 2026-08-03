<?php

namespace App\Filament\Resources\AiSystems;

use App\Filament\Resources\AiSystems\Pages\CreateAiSystem;
use App\Filament\Resources\AiSystems\Pages\EditAiSystem;
use App\Filament\Resources\AiSystems\Pages\ListAiSystems;
use App\Filament\Resources\AiSystems\Schemas\AiSystemForm;
use App\Filament\Resources\AiSystems\Tables\AiSystemsTable;
use App\Models\AiSystem;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AiSystemResource extends Resource
{
    protected static ?string $model = AiSystem::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return AiSystemForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AiSystemsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAiSystems::route('/'),
            'create' => CreateAiSystem::route('/create'),
            'edit' => EditAiSystem::route('/{record}/edit'),
        ];
    }
}
