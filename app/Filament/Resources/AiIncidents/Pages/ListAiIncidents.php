<?php

namespace App\Filament\Resources\AiIncidents\Pages;

use App\Filament\Resources\AiIncidents\AiIncidentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAiIncidents extends ListRecords
{
    protected static string $resource = AiIncidentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
