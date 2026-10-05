<?php

namespace App\Filament\Resources\AiIncidents;

use App\Filament\Resources\AiIncidents\Pages\CreateAiIncident;
use App\Filament\Resources\AiIncidents\Pages\EditAiIncident;
use App\Filament\Resources\AiIncidents\Pages\ListAiIncidents;
use App\Filament\Resources\AiIncidents\Schemas\AiIncidentForm;
use App\Filament\Resources\AiIncidents\Tables\AiIncidentsTable;
use App\Models\AiIncident;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AiIncidentResource extends Resource
{
    protected static ?string $model = AiIncident::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return AiIncidentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AiIncidentsTable::configure($table);
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
            'index' => ListAiIncidents::route('/'),
            'create' => CreateAiIncident::route('/create'),
            'edit' => EditAiIncident::route('/{record}/edit'),
        ];
    }
}
