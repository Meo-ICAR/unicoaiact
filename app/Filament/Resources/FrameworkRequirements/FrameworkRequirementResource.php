<?php

namespace App\Filament\Resources\FrameworkRequirements;

use App\Filament\Resources\FrameworkRequirements\Pages\CreateFrameworkRequirement;
use App\Filament\Resources\FrameworkRequirements\Pages\EditFrameworkRequirement;
use App\Filament\Resources\FrameworkRequirements\Pages\ListFrameworkRequirements;
use App\Filament\Resources\FrameworkRequirements\Schemas\FrameworkRequirementForm;
use App\Filament\Resources\FrameworkRequirements\Tables\FrameworkRequirementsTable;
use App\Models\FrameworkRequirement;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FrameworkRequirementResource extends Resource
{
    protected static ?string $model = FrameworkRequirement::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return FrameworkRequirementForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FrameworkRequirementsTable::configure($table);
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
            'index' => ListFrameworkRequirements::route('/'),
            'create' => CreateFrameworkRequirement::route('/create'),
            'edit' => EditFrameworkRequirement::route('/{record}/edit'),
        ];
    }
}
