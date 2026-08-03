<?php

namespace App\Filament\Resources\ComplianceFrameworks;

use App\Filament\Resources\ComplianceFrameworks\Pages\CreateComplianceFramework;
use App\Filament\Resources\ComplianceFrameworks\Pages\EditComplianceFramework;
use App\Filament\Resources\ComplianceFrameworks\Pages\ListComplianceFrameworks;
use App\Filament\Resources\ComplianceFrameworks\Schemas\ComplianceFrameworkForm;
use App\Filament\Resources\ComplianceFrameworks\Tables\ComplianceFrameworksTable;
use App\Models\ComplianceFramework;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ComplianceFrameworkResource extends Resource
{
    protected static ?string $model = ComplianceFramework::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ComplianceFrameworkForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ComplianceFrameworksTable::configure($table);
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
            'index' => ListComplianceFrameworks::route('/'),
            'create' => CreateComplianceFramework::route('/create'),
            'edit' => EditComplianceFramework::route('/{record}/edit'),
        ];
    }
}
