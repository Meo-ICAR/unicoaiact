<?php

namespace App\Filament\Resources\PqcSignatures;

use App\Filament\Resources\PqcSignatures\Pages\CreatePqcSignature;
use App\Filament\Resources\PqcSignatures\Pages\EditPqcSignature;
use App\Filament\Resources\PqcSignatures\Pages\ListPqcSignatures;
use App\Filament\Resources\PqcSignatures\Schemas\PqcSignatureForm;
use App\Filament\Resources\PqcSignatures\Tables\PqcSignaturesTable;
use App\Models\PqcSignature;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PqcSignatureResource extends Resource
{
    protected static ?string $model = PqcSignature::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return PqcSignatureForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PqcSignaturesTable::configure($table);
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
            'index' => ListPqcSignatures::route('/'),
            'create' => CreatePqcSignature::route('/create'),
            'edit' => EditPqcSignature::route('/{record}/edit'),
        ];
    }
}
