<?php

namespace App\Filament\Resources\BiasTests;

use App\Filament\Resources\BiasTests\Pages\CreateBiasTest;
use App\Filament\Resources\BiasTests\Pages\EditBiasTest;
use App\Filament\Resources\BiasTests\Pages\ListBiasTests;
use App\Filament\Resources\BiasTests\Schemas\BiasTestForm;
use App\Filament\Resources\BiasTests\Tables\BiasTestsTable;
use App\Models\BiasTest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BiasTestResource extends Resource
{
    protected static ?string $model = BiasTest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return BiasTestForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BiasTestsTable::configure($table);
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
            'index' => ListBiasTests::route('/'),
            'create' => CreateBiasTest::route('/create'),
            'edit' => EditBiasTest::route('/{record}/edit'),
        ];
    }
}
