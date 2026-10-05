<?php

namespace App\Filament\Resources\EsgAiMetrics\Pages;

use App\Filament\Resources\EsgAiMetrics\EsgAiMetricResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEsgAiMetric extends EditRecord
{
    protected static string $resource = EsgAiMetricResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
