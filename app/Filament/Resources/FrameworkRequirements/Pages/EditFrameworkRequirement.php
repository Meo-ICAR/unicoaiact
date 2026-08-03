<?php

namespace App\Filament\Resources\FrameworkRequirements\Pages;

use App\Filament\Resources\FrameworkRequirements\FrameworkRequirementResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFrameworkRequirement extends EditRecord
{
    protected static string $resource = FrameworkRequirementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
