<?php

namespace App\Filament\Resources\AiIncidents\Pages;

use App\Filament\Resources\AiIncidents\AiIncidentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAiIncident extends EditRecord
{
    protected static string $resource = AiIncidentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
