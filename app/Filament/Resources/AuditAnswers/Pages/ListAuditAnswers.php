<?php

namespace App\Filament\Resources\AuditAnswers\Pages;

use App\Filament\Resources\AuditAnswers\AuditAnswerResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAuditAnswers extends ListRecords
{
    protected static string $resource = AuditAnswerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
