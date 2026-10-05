<?php

namespace App\Filament\Resources\FriaAssessments;

use App\Filament\Resources\FriaAssessments\Pages\CreateFriaAssessment;
use App\Filament\Resources\FriaAssessments\Pages\EditFriaAssessment;
use App\Filament\Resources\FriaAssessments\Pages\ListFriaAssessments;
use App\Filament\Resources\FriaAssessments\Schemas\FriaAssessmentForm;
use App\Filament\Resources\FriaAssessments\Tables\FriaAssessmentsTable;
use App\Models\FriaAssessment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FriaAssessmentResource extends Resource
{
    protected static ?string $model = FriaAssessment::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return FriaAssessmentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FriaAssessmentsTable::configure($table);
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
            'index' => ListFriaAssessments::route('/'),
            'create' => CreateFriaAssessment::route('/create'),
            'edit' => EditFriaAssessment::route('/{record}/edit'),
        ];
    }
}
