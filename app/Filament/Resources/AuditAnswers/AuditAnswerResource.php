<?php

namespace App\Filament\Resources\AuditAnswers;

use App\Filament\Resources\AuditAnswers\Pages\CreateAuditAnswer;
use App\Filament\Resources\AuditAnswers\Pages\EditAuditAnswer;
use App\Filament\Resources\AuditAnswers\Pages\ListAuditAnswers;
use App\Filament\Resources\AuditAnswers\Schemas\AuditAnswerForm;
use App\Filament\Resources\AuditAnswers\Tables\AuditAnswersTable;
use App\Models\AuditAnswer;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AuditAnswerResource extends Resource
{
    protected static ?string $model = AuditAnswer::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return AuditAnswerForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AuditAnswersTable::configure($table);
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
            'index' => ListAuditAnswers::route('/'),
            'create' => CreateAuditAnswer::route('/create'),
            'edit' => EditAuditAnswer::route('/{record}/edit'),
        ];
    }
}
