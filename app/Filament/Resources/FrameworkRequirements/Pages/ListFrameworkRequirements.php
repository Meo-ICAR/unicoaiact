<?php

namespace App\Filament\Resources\FrameworkRequirements\Pages;

use App\Filament\Resources\FrameworkRequirements\FrameworkRequirementResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFrameworkRequirements extends ListRecords
{
    protected static string $resource = FrameworkRequirementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
