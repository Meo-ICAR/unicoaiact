<?php

namespace App\Filament\Resources\AuditAnswers\Pages;

use App\Filament\Resources\AuditAnswers\AuditAnswerResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAuditAnswer extends EditRecord
{
    protected static string $resource = AuditAnswerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
