<?php

namespace App\Filament\Resources\EsgAiMetrics;

use App\Filament\Resources\EsgAiMetrics\Pages\CreateEsgAiMetric;
use App\Filament\Resources\EsgAiMetrics\Pages\EditEsgAiMetric;
use App\Filament\Resources\EsgAiMetrics\Pages\ListEsgAiMetrics;
use App\Filament\Resources\EsgAiMetrics\Schemas\EsgAiMetricForm;
use App\Filament\Resources\EsgAiMetrics\Tables\EsgAiMetricsTable;
use App\Models\EsgAiMetric;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EsgAiMetricResource extends Resource
{
    protected static ?string $model = EsgAiMetric::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return EsgAiMetricForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EsgAiMetricsTable::configure($table);
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
            'index' => ListEsgAiMetrics::route('/'),
            'create' => CreateEsgAiMetric::route('/create'),
            'edit' => EditEsgAiMetric::route('/{record}/edit'),
        ];
    }
}
