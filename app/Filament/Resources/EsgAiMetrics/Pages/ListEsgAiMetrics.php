<?php

namespace App\Filament\Resources\EsgAiMetrics\Pages;

use App\Filament\Resources\EsgAiMetrics\EsgAiMetricResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEsgAiMetrics extends ListRecords
{
    protected static string $resource = EsgAiMetricResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
