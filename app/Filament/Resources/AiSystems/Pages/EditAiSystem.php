<?php

namespace App\Filament\Resources\AiSystems\Pages;

use App\Filament\Resources\AiSystems\AiSystemResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAiSystem extends EditRecord
{
    protected static string $resource = AiSystemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
